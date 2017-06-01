<style>.main,.side{float: left;}
 .main{width: 80%;}
 .side{width: 20%;}

</style>

<main class="main">
    <h2>Help : How to Use Danker Sitemap</h2>
    <h3>General Sitemap</h3>

   <p>Create Page and Use this Shortcode  <code>[danker_sitemap]</code> . Sitemap Image not included</p>


    <h3>Spesific Sitemap</h3>
    <p>Create Page and use this shortcodes:</p>
    <ol>
        <li>Page Only <code>[dn_sitemap_pages]</code></li>
        <li>Post  Only <code>[dn_sitemap_posts]</code></li>
        <li>Category Only <code>[dn_sitemap_categories]</code></li>
        <li>Category With Post <code>[dn_sitemap_catwpost]</code></li>
    </ol>

    <h3>Image Sietmap</h3>
    <p>Create Page and Use this Shortcode  <code>[danker_image_sitemap]</code> . </p>


    <h3> using Boostrap</h3>


    Implementation in page editor

   <pre>
&lt;div class="row"&gt;
    &lt;div class="col-md-6"&gt;[dn_sitemap_categories]&lt;/div&gt;
    &lt;div class="col-md-6"&gt;[dn_sitemap_pages]&lt;/div&gt;
    &lt;div class="col-md-12"&gt;[dn_sitemap_catwpost]&lt;/div&gt;
&lt;/div&gt;
    </pre>
    Implementation in theme <code>page-sitemap.php</code>

    <pre>&lt;div class="row"&gt;
    &lt;div class="col-md-6"&gt;
        &lt;?php echo do_shortcode( ' [ dn_sitemap_categories ] ' );?&gt;
    &lt;/div&gt;
    &lt;div class="col-md-6"&gt; &lt;?php echo do_shortcode( ' [ dn_sitemap_pages ] ' );?&gt;&lt;/div&gt;
    &lt;div class="col-md-12"&gt; &lt;?php echo do_shortcode( ' [ dn_sitemap_catwpost ] ' );?&gt;&lt;/div&gt;
&lt;/div&gt;</pre>

</main>
<aside class="side">
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
        <input type="hidden" name="cmd" value="_s-xclick">
        <input type="hidden" name="hosted_button_id" value="R45YAHZH6R4EY">
        <input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online!">
        <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
    </form>

</aside>
