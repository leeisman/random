<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>隨機選擇器</title>

    <link rel="shortcut icon" href="roulette.png"/>


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


    <!-- bootstrap-select -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.3/css/bootstrap-select.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.3/js/bootstrap-select.min.js"></script>


    <!-- bootstrap-switch CSS -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/css/bootstrap2/bootstrap-switch.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">


    {{--bootstrap-dialog --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.4/css/bootstrap-dialog.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.4/js/bootstrap-dialog.min.js"></script>
</head>
<body>
<div class="container" id="main-content">

    <div class="col-md-12">
        <h1>
            <img src="roulette.png" style="max-height: 120px; max-width: 120px">
            隨機選取機
        </h1>
        <p style="color: red">請在下方輸入隨機項目 </p>
    </div>

    <div class="col-md-12">
        <select class="selectpicker" id="types" v-model="type">
            <option v-for="type in types">@{{type}}</option>
        </select>
        <input type="button" value="新增類別" class="btn-primary" @click='addType'>
        <input type="button" value="清空所有類別項目" class="btn-danger" @click='clearCookies'>
    </div>

    <div class="col-md-12" style="margin-top: 20px;margin-bottom: 20px">
        <input type="button" value="新增項目" class="btn-primary" @click='addItems'>
        <input type="button" value="清空項目" class="btn-danger" @click='clearItems'>
        <input type="button" value="開始隨機選取" class="btn-success" @click='random'>
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
                <th scope="row">@{{ index+1 }}
                    <input type="button" value="X" @click='removeItem(index)'>
                </th>
                <td><input name="products[]" type="text" :value="item"></td>
            </tr>
            </tbody>

        </table>
    </div>

    <div class="col-md-12">
        <div class="make-switch switch-small">
            自動記錄：<input type="checkbox" checked="true" data-checkbox="VALUE1" class="alert-status">
        </div>
    </div>

</div>
</body>
</html>
<script>

    var vm = new Vue({
        el: '#main-content',
        data: {
            sampleItems: ['公館夜市', '師大夜市', '樂華夜市',
                '三和夜市', '樹林花園夜市夜市', '饒河夜市',
                '蘆洲夜市', '通化夜市', '士林夜市'],
            items: [],
            types: ['範本'],
            typeCookieName: 'randomTypes',
            type: null,
        },
        mounted: function () {

            this.type = '範本';

            var types = this.getCookie(this.typeCookieName);
            if (!types) {
                return;
            }

            this.types = types;
        },
        watch: {
            type: function (val) {
                if (val === '範本') {
                    this.items = this.sampleItems;
                    return;
                }

                this.items = this.getCookie(val);

                if (!this.items) {
                    this.items = ['','',''];
                }
            }
        },
        updated: function () {
            this.refreshSelectpicker();
        },
        methods: {
            refreshSelectpicker: function () {
                $('.selectpicker').selectpicker('refresh');
            },
            addType: function () {

                var that = this;

                BootstrapDialog.show({
                    title: '新增類別',
                    message: $('<input class="form-control" placeholder="請輸入類別名稱"></input>'),
                    buttons: [{
                        label: '完成',
                        cssClass: 'btn-primary',
                        hotkey: null, // Enter.
                        action: function (dialogItself) {
                            dialogItself.close();
                        }
                    }],
                    onhide: function (dialogRef) {
                        var typeName = dialogRef.getModalBody().find('input').val();
                        if (typeName.length > 0) {
                            that.insertTypeToCookie(typeName.toLowerCase());
                        }
                    },
                });
            },
            insertTypeToCookie: function (name) {
                this.types.push(name);
                this.setCookie(this.typeCookieName, this.types);
                this.type = name;
            },
            addItems: function () {

                var items = this.getInputItems();
                items.push('');
                this.items = items;
            },
            random: function () {

                var that = this;
                var values = this.getInputItems();
                this.setCookie(this.type, values);
                var item = values[Math.floor(Math.random() * values.length)];

                BootstrapDialog.show({
                    title: '恭喜你',
                    message: '你選中『' + item + '』 喔～ 想賴個皮可按鍵盤『Ａ』',
                    buttons: [{
                        label: '重選',
                        hotkey: 65, // Keycode of keyup event of key 'A' is 65.
                        action: function (dialogItself) {
                            that.random();
                            dialogItself.close();
                        }
                    },
                        {
                            label: '關閉',
                            hotkey: 13, // Keycode of keyup event of key 'A' is 65.
                            action: function (dialogItself) {
                                dialogItself.close();
                            }
                        },
                    ]
                });
            },
            getInputItems: function () {
                var values = $("input[name='products[]']")
                        .map(function () {
                            return $(this).val();
                        }).get();

                return values;
            },
            setCookie: function (name, items) {

                alert(items);
                document.cookie =  "types" + "=" +
                        items +
                        ";";

                alert(decodeURIComponent(document.cookie));
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
            removeItem: function (index) {
                this.items.splice(index, 1);
            },
            pushSampleItems: function () {
                this.items = this.sample;
            },
            clearItems: function () {
                this.items=[];
                this.setCookie(this.type, this.items);
            },
            clearCookies:function(){
                var cookie = document.cookie.split(';');
                for (var i = 0; i <cookie.length; i++) {
                    var chip = cookie[i],
                            entry = chip.split("="),
                            name = entry[0];
                    document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                }
                location.reload();
            }
        }

    })

    $('.selectpicker').selectpicker({
        style: 'btn-info',
        size: 4
    });

    $(function () {
        $('.alert-status').bootstrapSwitch('state', true);
    });

</script>
