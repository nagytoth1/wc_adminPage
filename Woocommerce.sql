/*`wp_wc_order_product_lookup` - táblában kiadja:
customer_id foreign key wc_customer_lookup -> ki vett  
product_id -> mit vett
product_qty -> mennyit vett
order_id -> egyedi rendelési azonosító 

wp_wc_customer_lookup - táblában kiadja:
neve, email, mikor vette, honnan vette stb..- */

SELECT c.last_name, c.first_name, p.product_qty FROM `wp_wc_order_product_lookup`
 as p INNER JOIN `wp_wc_customer_lookup` as c
 ON c.`customer_id`= p.customer_id

SELECT c.last_name, c.first_name, p.product_qty, pr.sku FROM `wp_wc_order_product_lookup`
as p INNER JOIN `wp_wc_customer_lookup` as c ON c.`customer_id`= p.customer_id INNER JOIN
`wp_wc_product_meta_lookup` as pr ON pr.product_id=p.product_id

-- Melyik termékből mennyit rendelt
SELECT c.last_name, c.first_name, p.product_qty, pr.order_item_name FROM `wp_wc_order_product_lookup` 
as p INNER JOIN `wp_wc_customer_lookup` as c 
ON c.`customer_id`= p.customer_id 
INNER JOIN  `wp_woocommerce_order_items` as pr 
ON pr.order_item_id=p.order_item_id

SELECT c.last_name, c.first_name, p.product_qty, pr.order_item_name FROM `wp_wc_order_product_lookup` 
as p INNER JOIN `wp_wc_customer_lookup` as c 
ON c.`customer_id`= p.customer_id 
INNER JOIN  `wp_woocommerce_order_items` as pr 
ON pr.order_item_id=p.order_item_id
WHERE c.first_name = '*keresznév*' AND c.last_name = '*vezetéknév*'
ORDER BY 3 DESC;

-- Rendelésenként a végösszegek 
SELECT p.order_id as "Rendelési azonosító", c.last_name as "Vezetéknév", c.first_name as "Keresztnév", ord.total_sales as "Rendelés végösszege (HUF)" FROM `wp_wc_order_product_lookup` 
as p INNER JOIN `wp_wc_customer_lookup` as c 
ON c.`customer_id`= p.customer_id 
INNER JOIN  `wp_wc_order_stats` as ord
WHERE p.date_created BETWEEN '2022-11-02 11:02' AND '2022-11-20 15:30'
ON ord.order_id = p.order_id
GROUP BY p.order_id;

-- Rendelések végösszegei user-enként, adott user rendeléseinek összeg
SELECT p.order_id as "Rendelési azonosító", c.last_name as "Vezetéknév", c.first_name as "Keresztnév", SUM(ord.total_sales) as "Rendelés végösszege (HUF)" FROM `wp_wc_order_product_lookup` 
as p INNER JOIN `wp_wc_customer_lookup` as c 
ON c.`customer_id`= p.customer_id 
INNER JOIN  `wp_wc_order_stats` as ord
ON ord.order_id = p.order_id
WHERE p.date_created BETWEEN '2022-11-02 11:02' AND '2022-11-20 15:30'
ORDER BY 4;

-- ugyanez, csak szűrés időpontra hülyeség
SELECT p.order_id as "Rendelési azonosító", p.date_created as "Rendelés időpontja", c.last_name as "Vezetéknév", c.first_name as "Keresztnév", SUM(ord.total_sales) as "Rendelés végösszege (HUF)" FROM `wp_wc_order_product_lookup` 
as p INNER JOIN `wp_wc_customer_lookup` as c 
ON c.`customer_id`= p.customer_id 
INNER JOIN  `wp_wc_order_stats` as ord
ON ord.order_id = p.order_id
WHERE p.date_created BETWEEN '2022-11-02 11:02' AND '2022-11-20 15:30'
GROUP BY p.customer_id
ORDER BY 4;

--átlagos kosárérték, rendelések átlaga userenként, Adott Felhasználó átlagban mennyit vásárol
SELECT c.last_name as "Vezetéknév", c.first_name as "Keresztnév", AVG(ord.net_total) as "Rendelés átlaga (HUF)" FROM `wp_wc_order_product_lookup` 
as p INNER JOIN `wp_wc_customer_lookup` as c 
ON c.`customer_id`= p.customer_id 
INNER JOIN  `wp_wc_order_stats` as ord
ON ord.order_id = p.order_id
WHERE p.date_created BETWEEN '2022-11-02 11:02' AND '2022-11-20 15:30' 
GROUP BY p.customer_id
ORDER BY 3;

--utolsó rendelés adott időszakban:
SELECT MAX(p.date_created) as "Rendelés időpontja", c.last_name as "Vezetéknév", c.first_name as "Keresztnév" FROM `wp_wc_order_product_lookup` 
as p INNER JOIN `wp_wc_customer_lookup` as c 
ON c.`customer_id`= p.customer_id 
INNER JOIN  `wp_wc_order_stats` as ord
ON ord.order_id = p.order_id
WHERE p.date_created BETWEEN '2022-11-02 11:02' AND '2022-11-20 15:30'
GROUP BY p.customer_id;


-- Vásárlások időpontjai:
SELECT p.date_created as "Vásárlások időpontjai", c.last_name as "Vezetéknév", c.first_name as "Keresztnév" FROM `wp_wc_order_product_lookup` 
as p INNER JOIN `wp_wc_customer_lookup` as c 
ON c.`customer_id`= p.customer_id 
INNER JOIN  `wp_wc_order_stats` as ord
ON ord.order_id = p.order_id
WHERE p.date_created BETWEEN '2022-11-02 11:02' AND '2022-11-20 15:30'
GROUP BY p.date_created;

-- Vásárlások száma vizsgált időszakban:
SELECT COUNT(ord.order_id) as "Vásárlások száma", c.last_name as "Vezetéknév", c.first_name as "Keresztnév" FROM `wp_wc_order_stats` 
as ord INNER JOIN `wp_wc_customer_lookup` as c 
ON c.`customer_id`= ord.customer_id 
WHERE ord.date_created BETWEEN '2022-11-02 11:02' AND '2022-11-20 15:30'
GROUP BY ord.customer_id;

--Wordpress fájl: php-ban plugins-ba betenni, header rész, hogy pluginként kezelje wordpress
--adminpage létrehozása, SQL-management Wordpress-ben -> API: formelemeket generál, asszociatív tömbben elemei formelemeknek
