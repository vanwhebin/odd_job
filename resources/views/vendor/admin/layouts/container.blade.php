<body
    class="dcat-admin-body sidebar-mini layout-fixed {{ $configData['body_class']}} {{ $configData['sidebar_class'] }}
    {{ $configData['navbar_class'] === 'fixed-top' ? 'navbar-fixed-top' : '' }} ">

<script>
    var Dcat = CreateDcat({!! Dcat\Admin\Admin::jsVariables() !!});
</script>

{!! admin_section(Dcat\Admin\Admin::SECTION['BODY_INNER_BEFORE']) !!}

<div class="wrapper">
    @include('admin::partials.sidebar')

    @include('admin::partials.navbar')

    <div class="app-content content">
        <div class="content-wrapper" id="{{ $pjaxContainerId }}" style="top: 0;min-height: 900px;">
            @yield('app')
        </div>
    </div>
</div>

<footer class="main-footer pt-1">
    <p class="clearfix blue-grey lighten-2 mb-0 text-center">
            <span class="text-center d-block d-md-inline-block mt-25">
                Powered by
                <a data-toggle="modal" href="#mymodal-link" id="href-btn"> Jourdon</a>
                <span>&nbsp;·&nbsp;</span>
                v{{ Dcat\Admin\Admin::VERSION }}
            </span>
        <!-- 模态弹出窗内容 -->
    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"
         id="mymodal-link">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">联系我</h4>
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>
                <div class="modal-body text-center">
                    <p>微信扫码加我为好友</p>
                    <img src="https://cloud.shark-baby.com/bgimage/contact.jpg?1231" alt="联系我">
                </div>
            </div>
        </div>
    </div>

    <button class="btn btn-primary btn-icon scroll-top pull-right"
            style="position: fixed;bottom: 2%; right: 10px;display: none">
        <i class="feather icon-arrow-up"></i>
    </button>
    </p>
</footer>

{!! admin_section(Dcat\Admin\Admin::SECTION['BODY_INNER_AFTER']) !!}

{!! Dcat\Admin\Admin::asset()->jsToHtml() !!}

<script>Dcat.boot();</script>

</body>

</html>
