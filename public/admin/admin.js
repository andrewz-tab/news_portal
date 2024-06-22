$(document).ready(function () {
    $(".nav-treeview .nav-link, .nav-link").each(function () {
        var location2 = window.location.protocol + '//' + window.location.host + window.location.pathname;
        var link = this.href;
        if(link == location2){
            $(this).addClass('active');
            $(this).parent().removeAttr('hidden');
            $(this).parent().parent().parent().addClass('menu-is-opening menu-open');
        }
    });

    $("[hidden]").filter("li").each(function (i, elem){
        elem.remove();
        }
    )


    $('.delete-btn').click(function () {
        var res = confirm('Подтвердите действия');
        if(!res){
            return false;
        }
    });
});
