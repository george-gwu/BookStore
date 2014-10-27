README
======



Setting Up Your VHOST
=====================

<VirtualHost *:80>
   DocumentRoot "/var/www/Bookstore/public"
   ServerName bookstore

   # This should be omitted in the production environment
   SetEnv APPLICATION_ENV development
    
   ErrorLog "logs/books-error_log"
   CustomLog "logs/books-access_log" combined
    
   <Directory "/var/www/Bookstore/public">
       Options Indexes MultiViews FollowSymLinks
       AllowOverride All
       Order allow,deny
       Allow from all
   </Directory>
    
</VirtualHost>