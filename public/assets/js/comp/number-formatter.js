$("input[data-type='only-number']").on({
    keyup: function() {
      format($(this));
    }
});

function clean(input) {
    return input.replace(/(\d)\D+|^[^\d+]/g, "$1").slice(0, 12);
}

function format(input) {
    var value = input.val();
    const [i, j] = [input[0].selectionStart, input[0].selectionEnd].map(i =>
        clean(value.slice(0, i)).length
    );
    input.val(clean(value));
    try {input[0].setSelectionRange(i, j);} catch {};
}
