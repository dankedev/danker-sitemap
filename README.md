# danker-sitemap
** easy to make simple sitemap page **

## Help : How to Use Danker Sitemap
### General Sitemap
Create Page and Use this Shortcode  `[danker_sitemap]` . Sitemap Image not included

### Spesific Sitemap
Create Page and use this shortcodes
* Page Only `[dn_sitemap_pages]`
* Post  Only <code>[dn_sitemap_posts]</code>
* Category Only <code>[dn_sitemap_categories]</code>
* Category With Post <code>[dn_sitemap_catwpost]</code>

### Image Sietmap 
    
Create Page and Use this Shortcode  <code>[danker_image_sitemap]</code> .

## using Boostrap


Implementation in page editor

```php
<div class="row">
    <div class="col-md-6">[dn_sitemap_categories]</div>
    <div class="col-md-6">[dn_sitemap_pages]</div>
    <div class="col-md-12">[dn_sitemap_catwpost]</div>
</div>
```
Implementation in theme `page-sitemap.php`

```php
<div class="row">
    <div class="col-md-6">
    <?php echo do_shortcode( ' [ dn_sitemap_categories ] ' );?>
    </div>
    <div class="col-md-6"> <?php echo do_shortcode( ' [ dn_sitemap_pages ] ' );?></div>
    <div class="col-md-12"> <?php echo do_shortcode( ' [ dn_sitemap_catwpost ] ' );?></div>
</div>
```


[buy me a coffe](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=R45YAHZH6R4EY)
