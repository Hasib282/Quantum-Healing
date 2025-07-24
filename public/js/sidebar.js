function SidebarAjax() {
    ///////////////////////// --------------- Toggle sidebar Functionality Start ----------------- ///////////////
    $(document).on('click', '.toggle-sidebar', function () {
        $('#mySidenav').toggleClass('hide');
    });



    $(document).on('click', '.menu-item', function (e) {
        $('.menu-item ul.sub-menu').not($(this).find('ul.sub-menu')).removeClass('show');
        $('.menu-item .menu-title i').not($(this).find('.menu-title i')).removeClass('rotate');
    });

    $(document).on('click', '.sub-menu-item', function (e) {
        $('.sub-menu-item ul.sub-menu1').not($(this).find('ul.sub-menu1')).removeClass('show');
        $('.sub-menu-item .menu-title i').not($(this).find('.menu-title i')).removeClass('rotate');
    });

    $(document).on('click', '.sub-menu1-item', function (e) {
        $('.sub-menu1-item ul.sub-menu2').not($(this).find('ul.sub-menu2')).removeClass('show');
        $('.sub-menu1-item .menu-title i').not($(this).find('.menu-title i')).removeClass('rotate');
    });

    $(document).on('click', '.sub-menu2-item', function (e) {
        $('.sub-menu2-item ul.sub-menu3').not($(this).find('ul.sub-menu3')).removeClass('show');
        $('.sub-menu2-item .menu-title i').not($(this).find('.menu-title i')).removeClass('rotate');
    });



    $(document).off('click', '.menu-title').on('click', '.menu-title', function (e) {
        let parent = $(this).parent();
        let active = $(this).hasClass('active');
        let baseURL = parent.data('url');

        if (!active && baseURL) {
            let url = baseURL.replace(/^(http[s]?:\/\/[^/]+)/, window.location.origin);
            history.pushState(null, '', url);

            $.ajax({
                url: url,
                method: 'GET',
                beforeSend: function () {
                    $('.main-content').html('<p>Loading...</p>');
                },
                success: function (res) {
                    $('.main-content').html(res);
                }
            });
        }
    });


    $(document).on('click', '.menu-item .menu-title', function (e) {
        $('.menu-item .menu-title').removeClass('active');

        $(this).toggleClass('active');
        let parent = $(this).parent();
        // console.log(parent);

        let subMenu = parent.find('.sub-menu');
        if (subMenu.length) {
            subMenu.toggleClass('show');
            let rightIcon = $(this).children().last();
            if (rightIcon.hasClass('fa-angle-right')) {
                rightIcon.toggleClass('rotate');
            }
        }
    });


    $(document).on('click', '.sub-menu-item .menu-title', function (e) {
        $(this).toggleClass('active');
        let parent = $(this).parent();
        let subMenu = parent.find('.sub-menu1');
        if (subMenu.length) {
            subMenu.toggleClass('show');
            $(this).toggleClass('active');
            let rightIcon = $(this).children().last();
            if (rightIcon.hasClass('fa-angle-right')) {
                rightIcon.toggleClass('rotate');
            }
        }
        else {
            $(this).toggleClass('active');
        }
    });


    $(document).on('click', '.sub-menu1-item .menu-title', function (e) {
        $(this).toggleClass('active');
        let parent = $(this).parent();
        let subMenu = parent.find('.sub-menu2');
        if (subMenu.length) {
            subMenu.toggleClass('show');
            $(this).toggleClass('active');
            let rightIcon = $(this).children().last();
            if (rightIcon.hasClass('fa-angle-right')) {
                rightIcon.toggleClass('rotate');
            }
        }
        else {
            $(this).toggleClass('active');
        }
    });

    $(document).on('click', '.sub-menu2-item .menu-title', function (e) {
        $(this).toggleClass('active');
        let parent = $(this).parent();
        let subMenu = parent.find('.sub-menu3');


        if (subMenu.length) {
            subMenu.toggleClass('show');
            $(this).toggleClass('active');
            let rightIcon = $(this).children().last();
            if (rightIcon.hasClass('fa-angle-right')) {
                rightIcon.toggleClass('rotate');
            }
        }
        else {
            $(this).toggleClass('active');
        }
    });
    
}