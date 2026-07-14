<?php

return array (
  'class_namespace' => 'App\\Livewire',
  'view_path' => '/var/www/html/resources/views/livewire',
  'layout' => 'components.layouts.app',
  'lazy_placeholder' => NULL,
  'temporary_file_upload' => 
  array (
    'disk' => 'public',
    'rules' => 
    array (
      0 => 'required',
      1 => 'file',
      2 => 'max:200000',
    ),
    'directory' => 'livewire-tmp',
    'middleware' => 'throttle:60,1',
    'preview_mimes' => 
    array (
      0 => 'png',
      1 => 'gif',
      2 => 'bmp',
      3 => 'svg',
      4 => 'wav',
      5 => 'mp4',
      6 => 'mov',
      7 => 'avi',
      8 => 'wmv',
      9 => 'mp3',
      10 => 'm4a',
      11 => 'jpg',
      12 => 'jpeg',
      13 => 'mpga',
      14 => 'webp',
      15 => 'wma',
      16 => 'webm',
      17 => 'ogg',
      18 => 'ogv',
      19 => 'mkv',
      20 => 'mpeg',
      21 => '3gp',
    ),
    'max_upload_time' => 5,
    'cleanup' => true,
  ),
  'render_on_redirect' => false,
  'legacy_model_binding' => false,
  'inject_assets' => true,
  'navigate' => 
  array (
    'show_progress_bar' => true,
    'progress_bar_color' => '#2299dd',
  ),
  'inject_morph_markers' => true,
  'pagination_theme' => 'tailwind',
);
