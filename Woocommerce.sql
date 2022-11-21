/* `wp_wc_order_product_lookup` - táblában kiadja:
        customer_id foreign key wc_customer_lookup -> ki vett  
        product_id -> mit vett
        product_qty -> mennyit vett
        order_id -> egyedi rendelési azonosító 

    `wp_wc_customer_lookup` - táblában kiadja:
        neve, email, mikor vette, honnan vette stb.. 
    `wp_woocommerce_order_items` - táblában kiadja:
        termék id + neve
    `wp
*/

-- 1. Melyik termékből mennyit rendelt
SELECT c.last_name, c.first_name, pr.order_item_name, SUM(p.product_qty) as 'sum_product_qty'
FROM `wp_wc_order_product_lookup` as p 
INNER JOIN `wp_woocommerce_order_items` as pr 
ON pr.order_item_id=p.order_item_id 
INNER JOIN `wp_wc_customer_lookup` as c 
ON c.`customer_id`= p.customer_id 
WHERE c.email='mail@chimp.com' 
AND p.date_created BETWEEN '2022-01-01' AND now() 
GROUP BY 3
ORDER BY 4 DESC;

-- 2. Rendelésenként a végösszegek 
SELECT ord.order_id, c.last_name, c.first_name, ord.total_sales
FROM wp_wc_customer_lookup as c 
INNER JOIN wp_wc_order_stats as ord 
ON ord.customer_id = c.customer_id 
WHERE c.email='mail@chimp.com'
AND ord.date_created BETWEEN '2022-01-01' AND now()
ORDER BY 4 DESC;

-- 3. Rendelések végösszegei user-enként, adott user rendeléseinek összeg
SELECT ord.order_id, c.last_name, c.first_name, SUM(ord.total_sales) 
FROM wp_wc_customer_lookup as c 
INNER JOIN wp_wc_order_stats as ord 
ON ord.customer_id = c.customer_id 
WHERE c.email='mail@chimp.com' 
AND ord.date_created BETWEEN '2022-01-01' AND now();

--4. átlagos kosárérték, rendelések átlaga userenként, Adott Felhasználó átlagban mennyit vásárol
SELECT c.last_name, c.first_name , AVG(ord.total_sales) as 'avg_total_sales'
FROM wp_wc_customer_lookup as c 
INNER JOIN  wp_wc_order_stats as ord
ON ord.customer_id = c.customer_id
WHERE c.email = 'mail@chimp.com'
AND ord.date_created BETWEEN '2022-01-01' AND now();

--5. utolsó rendelés adott időszakban:
SELECT c.last_name, c.first_name, MAX(ord.date_created) as 'max_date'
FROM `wp_wc_customer_lookup` as c 
INNER JOIN  `wp_wc_order_stats` as ord
ON ord.customer_id = c.customer_id
WHERE c.email = 'mail@chimp.com' 
AND ord.date_created BETWEEN '2022-01-01' AND now();


--6. Vásárlások időpontjai:
SELECT c.last_name , c.first_name, ord.date_created, ord.order_id 
FROM wp_wc_order_stats as ord 
INNER JOIN wp_wc_customer_lookup as c 
ON c.customer_id = ord.customer_id 
WHERE c.email = 'mail@chimp.com' 
AND ord.date_created BETWEEN '2022-01-01' AND now();


--7. Vásárlások száma vizsgált időszakban:
SELECT c.last_name, c.first_name, COUNT(ord.order_id) as 'count_orders' 
FROM wp_wc_order_stats as ord 
INNER JOIN wp_wc_customer_lookup as c 
ON c.customer_id=ord.customer_id 
WHERE c.email='mail@chimp.com' 
AND ord.date_created BETWEEN '2022-01-01' AND now();

--Wordpress fájl: php-ban plugins-ba betenni, header rész, hogy pluginként kezelje wordpress
--adminpage létrehozása, SQL-management Wordpress-ben -> API: formelemeket generál, asszociatív tömbben elemei formelemeknek
