$(document).ready(() => {
    $("#cart-link").click(function (e) {
        e.preventDefault();
        getCart();
        $("#cart").modal("show");
    });

    $("#block-pjax").on("click", ".add-to-cart", function (e) {
        e.preventDefault();
        const btn = $(this);
        $.ajax({
            url: "cart/add",
            method: "post",
            data: { id: $(this).data("id") },
            async: false,
            success: (data) => {
                console.log(data);

                if (data === false) {
                }

                // if( data && btn.hasClass('btn-rnd'))
            },
        });
    });

    $("#body-cart").on("click", ".btn-delete", function (e) {
        e.preventDefault();
        $.ajax({
            url: "/cart/delete-one-item",
            method: "post",
            data: { id: $(this).data("id") },
            async: false,
            success: (data) => {
                if (data) {
                    getCart();
                }
            },
        });
    });

    $("#body-cart").on("click", ".btn-plus", function (e) {
        e.preventDefault();
        $.ajax({
            url: "/cart/add",
            method: "post",
            data: { id: $(this).data("id") },
            async: false,
            success: (data) => {

                if(data === false) {
                    $('#modal-error').modal('show');
                    setTimeout(function(){
                        $('#modal-error').modal('hide');
                    }, 2000)
                }

                if (data) {
                    getCart();
                }
            },
        });
    });

    $("#body-cart").on("click", ".btn-delete-item", function (e) {
        e.preventDefault();
        if (confirm("Вы точно хотите удалить данный товар из корзины?")) {
            $.ajax({
                url: "/cart/delete-item",
                method: "post",
                data: { id: $(this).data("id") },
                async: false,
                success: (data) => {
                    if (data) {
                        getCart();
                    }
                },
            });
        }
    });

    $("#clear").click(function (e) {
        e.preventDefault();
        $.ajax({
            url: "/cart/clear",
            method: "post",
            async: false,
            success: function (data) {
                if (data) {
                    getCart();
                }
            },
        });
    });

    function getCart() {
        $.ajax({
            url: "/cart/view",
            method: "post",
            sync: false,
            success: function (data) {
                $("#body-cart").html(data);
                if (data) {
                    $("#body-cart").html(data);
                }
            },
        });
    }
});
