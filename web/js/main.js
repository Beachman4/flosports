$(document).ready(function() {
    var toppings = [
        "pepperoni",
        "beef",
        "ham",
        "italian_sausage",
        "pork",
        "chicken",
        "mushrooms",
        "onions",
        "green_bell_pepper",
        "spinach",
        "tomato",
        "olives",
        "pineapple",
        "jalepeno"
    ]
    var pizza_types = [
        'pan',
        'hand_tossed',
        'thin'
    ]

    $('.toppings_container input:checkbox').change(function() {
        var selected = [];
        $('.toppings_container input:checked').each(function() {
            selected.push($(this).val());
        })
        if (selected.length == 5) {
            $('.toppings_container input:checkbox:not(:checked)').attr('disabled', true)
        }
        if (selected.length < 5) {
            $('.toppings_container input:checkbox:not(:checked)').attr('disabled', false)
        }
        hideNotSelected(selected, toppings);
    });

    $('.pizza_type_container input:radio').change(function() {
        var type = $('.pizza_type_container input:checked').val();

        hideNotSelected([type], pizza_types);
    })



    function hideNotSelected(selected, array) {
        array.forEach(function(item) {

            if (selected.length == 0) {
                $('#' + item).hide();
            } else {
                if (selected.indexOf(item) === -1) {
                    $('#' + item).hide();
                } else {
                    $('#' + item).show();
            }
            }
        })
    }

    var inputs = ['first_name', 'last_name', 'phone'];

    // Step stuff

    $('#step1_button').click(function (e) {
        e.preventDefault();

        if (!checkEmptyInputs()) {
            $('.error').html("<h4>Please fill out the inputs below!</h4>");
            return false;
        }
        $('.error').html("");
        $(this).parent().hide();

        $('#step2').show(1000);
    })

    function checkEmptyInputs() {
        var passed = true;
        inputs.forEach(function(item) {
            if ($('#' + item).val().trim() == "") {
                passed = false;
            }
        })
        return passed;
    }

});