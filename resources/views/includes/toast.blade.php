@if(session('toast-message'))
<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="liveToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <strong class="me-auto">{{session('toast-label')}}</strong>
      <small>Qualche secondo fa</small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body d-flex align-items-center justify-content-between">
     {{session('toast-message')}}

        @if(session( 'toast-message'))
        @if (session('toast-method' === 'GET'))
         <a href="{{session('toast-route')}}" class="btn btn-sm btn-outline-{{session('toast-button-label')}}">{{session('toast-button-label')}}</a>
        @else
            <form action="{{session('toast-route')}}" method="POST">
                @csrf
                @method(session( 'toast-method'))
                <button class="btn btn-sm btn-outline-{{session('toast-button-label')}}">{{session('toast-button-label')}}</button>
                
            </form>
        @endif
        @endif

    </div>
  </div>
</div>
@endif