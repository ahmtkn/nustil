{{--{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}--}}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($data as $item)
        <url>
            <loc>{{$item->url}}</loc>
            <lastmod>{{$item->updated_at->tz('UTC')->toAtomString()}}</lastmod>
            <changefreq>{{$item->frequency}}</changefreq>
            @if(!is_null($item->priority))
                <priority>{{$item->priority}}</priority>
            @endif
        </url>
    @endforeach
</urlset>
