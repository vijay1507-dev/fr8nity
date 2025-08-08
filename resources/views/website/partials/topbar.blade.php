<!-- Top Header -->
<div class="top_head">
  <div class="container">
    <div class="row position-relative z-3">
      <div class="col-12 col-md-6">                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       
        <ul>
          <li><img src="{{asset('images/call_icon.png')}}" alt="Call Icon" />
            @if(!empty($siteSettings['site_phone']))
              <a href="tel:{{ $siteSettings['site_phone'] }}">{{ $siteSettings['site_phone'] }}</a>
            @endif
          </li>
          <li><img src="{{asset('images/mail_icon.png')}}" alt="Mail Icon" />
            @if(!empty($siteSettings['site_email']))
              <a href="mailto:{{ $siteSettings['site_email'] }}">{{ $siteSettings['site_email'] }}</a>
            @endif
          </li>
        </ul>
      </div>
      <div class="col-12 col-md-6">
        <ul class="justify-content-end gap-1 d-flex">
          @if(!empty($siteSettings['social_facebook']))
            <li><a href="{{ $siteSettings['social_facebook'] }}" target="_blank" rel="noopener"><img src="{{asset('images/fb_icon.png')}}" alt="Facebook" /></a></li>
          @endif
          @if(!empty($siteSettings['social_instagram']))
            <li><a href="{{ $siteSettings['social_instagram'] }}" target="_blank" rel="noopener"><img src="{{asset('images/insta_icon.png')}}" alt="Instagram" /></a></li>
          @endif
          @if(!empty($siteSettings['social_twitter']))
            <li><a href="{{ $siteSettings['social_twitter'] }}" target="_blank" rel="noopener"><img src="{{asset('images/x_icon.png')}}" alt="X" /></a></li>
          @endif
          @if(!empty($siteSettings['social_youtube']))
            <li><a href="{{ $siteSettings['social_youtube'] }}" target="_blank" rel="noopener"><img src="{{asset('images/youtube_icon.png')}}" alt="YouTube" /></a></li>
          @endif
        </ul>
      </div>
    </div>
  </div>
</div>
