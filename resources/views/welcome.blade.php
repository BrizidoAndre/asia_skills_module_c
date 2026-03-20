<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
</head>
<body>
<div class="container d-flex flex-column gap-2 py-3" id="main">
    <textarea class="form-control" name="content[]" rows="1"></textarea>
</div>
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
<script>
    const mainContainer = document.getElementById('main');
    mainContainer.addEventListener('keydown', (ev) => {
        if (ev.target.tagName === 'TEXTAREA') {
            const area = ev.target;
            const {key, shiftKey} = ev;
            if (key === 'Enter') {
                if (shiftKey) {
                    area.rows = parseInt(area.rows) + 1;
                } else {
                    ev.preventDefault();

                    const newText = document.createElement('textarea');
                    newText.classList.add('form-control');
                    newText.rows = 1;
                    newText.name = 'content[]';
                    mainContainer.appendChild(newText);
                    newText.focus();
                }
            }
            if (key === 'Backspace' && area.value === '' && mainContainer.children.length > 1) {
                ev.preventDefault();
                const prev = area.previousSibling;
                area.remove();
                if (prev) {
                    prev.focus()
                }
            }
        }
    })
</script>
</body>
</html>
