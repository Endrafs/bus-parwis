@php
  $items = $section->mediaItems ?? collect();
@endphp
@if($items->isNotEmpty())
  <div class="gallery-grid stagger-children {{ isset($animate) && $animate ? 'animate-on-scroll' : '' }}">
    @foreach($items as $item)
      <div class="gallery-item" style="animation-delay:{{ $loop->index * 60 }}ms;">
        @switch($item->media_type)
          @case('image')
            <img src="{{ $item->url }}" alt="{{ $item->caption ?? 'Gallery image' }}" loading="lazy" />
            @break
          @case('video')
            @php
              $ext = strtolower(pathinfo($item->url, PATHINFO_EXTENSION));
              $mime = match($ext) {
                'webm' => 'video/webm',
                'ogg', 'ogv' => 'video/ogg',
                'mov' => 'video/quicktime',
                'avi' => 'video/x-msvideo',
                'mkv' => 'video/x-matroska',
                default => 'video/mp4',
              };
            @endphp
            <video muted loop playsinline>
              <source src="{{ $item->url }}" type="{{ $mime }}">
            </video>
            @break
          @case('youtube')
            <iframe src="{{ $item->getYoutubeEmbedUrl() }}" frameborder="0" allowfullscreen
                    style="width:100%;height:100%;border:none;"></iframe>
            @break
        @endswitch
        @if($item->caption)
          <div class="gallery-caption">{{ $item->caption }}</div>
        @endif
      </div>
    @endforeach
  </div>
@endif
