<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/css/bootstrap2/bootstrap-switch.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <script src="https://cdn.bootcss.com/vue/2.3.4/vue.min.js"></script>

    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/bootstrap.switch/4.0.0-alpha.1/css/bootstrap-switch.min.css">
    <script src="https://cdn.jsdelivr.net/bootstrap.switch/4.0.0-alpha.1/js/bootstrap-switch.min.js"></script>


</head>
<body>
<div class="container" id="main-content">
    <div class="col-md-12" style="margin-top: 20px">
        <input type="button" value="增加" class="btn-primary" @click='addItems'>
        <input type="button" value="Random" class="btn-success" @click='random'>
    </div>
    <div class="col-md-12">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>名稱</th>
            </tr>
            </thead>
            <tbody v-for="item,index in items">
            <tr>
                <th scope="row">@{{ index+1 }}</th>
                <td><input name="products[]" type="text" :value="item"></td>
            </tr>
            </tbody>

        </table>
    </div>

</div>
</body>
</html>
<script>

    var vm = new Vue({
        el: '#main-content',
        data: {
            items: 1,
            randomItems: []
        },
        methods: {
            addItems: function () {
                this.items++;
            },
            random: function () {

                var values = this.getRandomItems();
                this.setCookie('randomItems',values);
                var item = values[Math.floor(Math.random() * values.length)];

                alert(item);
            },
            getRandomItems: function () {
                var values = $("input[name='products[]']")
                        .map(function () {
                            return $(this).val();
                        }).get();

                return values;
            },
            setCookie: function (name, items) {
                document.cookie = name + "=" +
                        items +
                        ";path=/";
            },
            getCookie: function (name) {
                var decodedCookie = decodeURIComponent(document.cookie);
                var ca = decodedCookie.split(';');

                for (var i = 0; i < ca.length; i++) {
                    var c = ca[i];
                    while (c.charAt(0) == ' ') {
                        c = c.substring(1);
                    }
                    if (c.indexOf(name) == 0) {
                        return c.substring(name.length + 1, c.length).split(',');
                    }
                }
            },
        }

    })

    var items = vm.getCookie('randomItems');
    if(items.length > 0){
        vm.items = this.items;
    }
    console.log(vm.getCookie('randomItems'));

</script>
