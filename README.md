# wc_adminPage

Fejlesztve PHP 8.1.10 és Apache/2.4.54 és Wordpress 6.1.1 és WooCommerce 7.1.0 verzióra.

Wordpress-plugin egy próba webshop felhasználóinak vásárlói tevékenységek elemzésére.
Ahhoz hogy működjön, a repository mappáját a WP-projekt wp-content\plugins mappájában kell elhelyezni.
Ezután a WP Dashboard-on már láthatjuk is a telepített plugin-ok között, itt találjuk a "Color Admin Page" néven.
Ezt engedélyezve megjelenik a bal oldali oldalsávban egy újabb fül "Admin Plugin" néven.
Erre kattintva futtathatjuk is a lekérdezéseket arra a felhasználó email címére, amelynek tevékenységére kiváncsiak vagyunk a megadott időszakban.

Adatbázis-lekérdezések a következő táblákra történnek:
  1. `wp_wc_order_product_lookup`
  2. `wp_woocommerce_order_items`
  3. `wp_wc_customer_lookup`
  4. `wp_wc_order_stats`

Az adatbázisunk neve: `wordpressdb` volt.
Az alapból létrehozott WP-táblákon végzünk lekérdezéseket, a `wp_` prefix változhat, egyébként ezeknek a táblaneveknek kell maradniuk az eredeti mezőneveikkel, hogy a lekérdezések ne fussanak hibára.
