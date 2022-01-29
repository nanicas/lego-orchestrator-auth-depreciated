var LOGIN = (function () {

    var state;

    function load() {

        state = {
            applicationLoad: $('#applications-loading'),
            applicationsBox: $('#applications-box')
        };

        $('.application').click(function (e) {
            e.stopPropagation();
            e.preventDefault();

            var self = $(this);
            state.applicationLoad.show();

            $.ajax({
                url: self.attr('href'),
                type: 'GET',
                dataType: 'JSON',
                complete: function () {
                    state.applicationLoad.hide();
                },
                success: function (data) {
                    self.parent().find('> .content-slugs').html(data.response.html);
                }
            })
        });
    }

    return {load};
})();

window.onload = function () {

    if (APP !== undefined && typeof APP.load == 'function') {
        APP.load();
    }

    LOGIN.load();
}