<?php echo '<?xml version="1.0" encoding="UTF-8"?>';?>
<urlset 
<?php echo '
xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
';?>
    <url>
        <loc>{{ url('/') }}/</loc>
        <lastmod>{{ $date }}</lastmod>
        <priority>1.00</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/livedraw</loc>
        <lastmod>{{ $date }}</lastmod>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/result</loc>
        <lastmod>{{ $date }}</lastmod>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/about</loc>
        <lastmod>{{ $date }}</lastmod>
        <priority>0.80</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/contact</loc>
        <lastmod>{{ $date }}</lastmod>
        <priority>0.80</priority>
    </url>
    @for ($x=2;$x<=$resultNumbers->lastPage();$x++)
        <url>
            <loc>{{ url('/') }}/result?page={{ $x }}</loc>
            <lastmod>{{ $date }}</lastmod>
            <priority>0.80</priority>
        </url>
    @endfor
</urlset>
