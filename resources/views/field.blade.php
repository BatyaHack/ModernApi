@extends('layout.master')

@section('content')

    <form action="#">
        <input type="text" name="field" id="feild">
        <input type="submit" id="send">
    </form>
    
@endsection
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", ready);

    function ready() {
        const buttonSend = document.getElementById(`send`);
        const inputForm = document.getElementById(`feild`);

        buttonSend.addEventListener(`click`, function (evt) {
            evt.preventDefault();

            var value = inputForm.value;

            const data = {
                test: value,
            }


            fetch('/api/field', {
                method: `POST`,
                body: JSON.stringify(data),
                headers: {
                    'Access-Control-Allow-Origin': `*`,
                    'Content-Type': `application/json`,
                },
            })
                .then((data) => {
                console.log(data.json());
            })
        });
    }


</script>