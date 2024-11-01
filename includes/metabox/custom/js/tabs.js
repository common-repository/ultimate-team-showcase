(function ($) {
    // Initial check
    if ($('.rstheme-tabs').length) {
        $('.rstheme-tabs').each(function () {
            // Activate the last active tab or the first tab if none is set
            var activeTab = localStorage.getItem('activeTab') || $(this).find('.rstheme-tab').first().data('fields');
            $(this).find('.rstheme-tab[data-fields="' + activeTab + '"]').addClass('active');
            $(activeTab).addClass('rstheme-tab-active-item');
           
            // Support for groups and repeatable fields
            $(activeTab).find('.rstheme-repeat .rstheme-row, .rstheme-repeatable-group .rstheme-row').addClass('rstheme-tab-active-item');
        });
    }

    $('body').on('click.rsthemeTabs', '.rstheme-tabs .rstheme-tab', function (e) {
        var tab = $(this);

        if (!tab.hasClass('active')) {
            var tabs = tab.closest('.rstheme-tabs');
            var form = tabs.next('.rstheme-wrap');
            var fieldsToShow = tab.data('fields');

            // Hide current active tab fields
            form.find(tabs.find('.rstheme-tab.active').data('fields')).fadeOut('fast', function () {
                $(this).removeClass('rstheme-tab-active-item');

                // Show the new active tab fields
                form.find(fieldsToShow).fadeIn('fast', function () {
                    $(this).addClass('rstheme-tab-active-item');

                    // Support for groups and repeatable fields
                    $(this).find('.rstheme-repeat-table .rstheme-row, .rstheme-repeatable-group .rstheme-row').addClass('rstheme-tab-active-item');
                });

                // Update tab active class
                tabs.find('.rstheme-tab.active').removeClass('active');
                tab.addClass('active');

                // Save the active tab in local storage
                localStorage.setItem('activeTab', fieldsToShow);
            });
        }
    });

    // Adding a new group element needs to get the active class also
    $('body').on('click', '.rstheme-add-group-row', function () {
        $(this).closest('.rstheme-repeatable-group').find('.rstheme-row').addClass('rstheme-tab-active-item');
    });

    // Adding a new repeatable element needs to get the active class also
    $('body').on('click', '.rstheme-add-row-button', function () {
        $(this).closest('.rstheme-repeat').find('.rstheme-row').addClass('rstheme-tab-active-item');
    });

    // Initialize on widgets area
    $(document).on('widget-updated widget-added', function (e, widget) {
        if (widget.find('.rstheme-tabs').length) {
            widget.find('.rstheme-tabs').each(function () {
                // Activate the last active tab or the first tab if none is set
                var activeTab = localStorage.getItem('activeTab') || $(this).find('.rstheme-tab').first().data('fields');
                $(this).find('.rstheme-tab[data-fields="' + activeTab + '"]').addClass('active');
                $(activeTab).addClass('rstheme-tab-active-item');

                // Support for groups and repeatable fields
                $(activeTab).find('.rstheme-repeat .rstheme-row, .rstheme-repeatable-group .rstheme-row').addClass('rstheme-tab-active-item');
            });
        }
    });

})(jQuery);
