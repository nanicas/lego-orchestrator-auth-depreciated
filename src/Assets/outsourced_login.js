var LOGIN = (function () {

    var state;

    function load() {

        state = {
            applicationLoad: $('#applications-loading'),
            applicationsBox: $('#applications-box'),
            slugsBox: $('#slugs-box')
        };

        $('.application').click(function (e) {
            e.stopPropagation();
            e.preventDefault();

            var slug = state.slugsBox.find('input[name="slug"]:checked'),
                self = $(this);
                
            state.applicationLoad.show();

            $.ajax({
                url: self.attr('href'),
                type: 'GET',
                data: {slug: (slug.length > 0) ? slug.val() : null},
                dataType: 'TEXT',
                complete: function () {
                    state.applicationLoad.hide();
                },
                success: function (link) {
                    //self.parent().find('> .content-slugs').html(data.response.html);
                    window.location.href = link;
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