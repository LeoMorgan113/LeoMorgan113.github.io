<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Обчислення</title>
    <link href="https://fonts.googleapis.com/css2?family=El+Messiri:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style_lab3.css">
    <link rel="stylesheet" type="text/css" href="test.css">
</head>
<body>

<div class="container">
    <?php
    $format_POST_array = [];
    while (list($key, $val) = each($_POST)) {
        if ($key === "submit"){
            break;
        }
        $val_arr = unserialize(str_replace('`', '', $val));

        array_push($format_POST_array, $val_arr);
    }
    print_r($format_POST_array);
    ?>
    <div class="row">
        <div class="col-12">
            <a href="../index.html"><img src="../img/LOGO.svg" alt="Logo" class="logo"></a>
            <h1>Моделювання графіка електричного навантаження</h1>
        </div>
        <div class="col-6" style="display:inline-flex;">
            <a href="../lab3/index.php"><img src="../img/Arrow_left.png" alt="Left"></a>
        </div>
        <div class="col-6" style="display:flex; justify-content: flex-end;">
            <a href="../lab4/index.html" ><img src="../img/Arrow_right.png" alt="Right" ></a>
        </div>
        <div class="col-12 wrapper">
            <form method="post" action="show.php">
                <div class="row" id="resultTable" bordered="4">
                    <script type="text/javascript">
                        let devices_array = <?php echo json_encode($format_POST_array); ?>;
                        let id_array = [];
                        let output = ``;
                        let days = new Map([
                            ["Monday", "Понеділок"],
                            ["Tuesday", "Вівторок"],
                            ["Wednesday", "Середа"],
                            ["Thursday", "Четвер"],
                            ["Friday", "П'ятниця"],
                            ["Saturday", "Субота"],
                            ["Sunday", "Неділя"]
                        ]);

                        for(let device of devices_array) {
                            let type = device['2'];
                            let iterator = 0;
                            output += ` <div class="col-12" style="margin: 15px;"><h3 colspan="3">${device['1']}, ${device[5]}</h3></div>`;

                            if(type === "on/off" || type === "on/auto") {
                                id_array.push(device['0']);

                                if(type === "on/off") {
                                //     output += `
                                //  <input style="display: none" name="valueOnOff['${device['0']}']['name']" value=${device[1]} >
                                // <input style="display: none" name="valueOnOff['${device['0']}']['type']" value=${device[2]} >
                                // <input style="display: none" name="valueOnOff['${device['0']}']['power']" value=${device[5]} >`;
                                    for (let pair of days) {
                                        output += `
                                        <div class="col-3" style="margin-bottom: 40px;">
                                                <span style="display: inline-block; margin: 10px;">${pair[1]}</span>
                                                <span style="display: inline-block">
                                                <button id="buttonAddRowOnOff_${device['0']}_${pair[0]}" class="button-add-row">+</button>
                                                </span>
                                            <div class="select-row_${device['0']}_${pair[0]} clearfix"></div>
                                        </div>`;
                                    }
                                }else {
                                    output += `
                                        <input style="display: none" name="valueOnAuto['${device['0']}']['name']" value=${device[1]}>
                                        <input style="display: none" name="valueOnAuto['${device['0']}']['type']" value=${device[2]}>
                                        <input style="display: none" name="valueOnAuto['${device['0']}']['power']" value=${device[5]}>
                                        <input style="display: none" name="valueOnAuto['${device['0']}']['duration']" value=${device[6]}>
                                        <input style="display: none" name="valueOnAuto['${device['0']}']['dev_dur']" value=${device[7]}>
                                        `;
                                    for (let pair of days) {
                                        output += `
                                        <div class="col-3" style="margin-bottom: 40px;">
                                                <span style="display: inline-block; margin: 10px;">${pair[1]}</span>
                                                <span style="display: inline-block">
                                                <button id="buttonAddRowOnAuto_${device['0']}_${pair[0]}" class="button-add-row">+</button>
                                                </span>
                                        
                                            <div class="select-row_${device['0']}_${pair[0]} clearfix"></div>
                                        </div>
                                    `;
                                    }
                                }

                            }else if(type === "auto"){
                                output += `
                                        <input style="display: none" name="valueAuto['${device['0']}']['name']" value=${device[1]}>
                                        <input style="display: none" name="valueAuto['${device['0']}']['type']" value=${device[2]}>
                                        <input style="display: none" name="valueAuto['${device['0']}']['power']" value=${device[5]}>
                                        <input style="display: none" name="valueAuto['${device['0']}']['duration']" value=${device[6]}>
                                        <input style="display: none" name="valueAuto['${device['0']}']['dev_dur']" value=${device[7]}>
                                        <input style="display: none" name="valueAuto['${device['0']}']['break_dur']" value=${device[8]}>
                                `;
                                iterator += 1;
                            }
                        }
                        let el = document.getElementById("resultTable");
                        el.innerHTML = output;

                        </script>
                    </div>
                <button class="button" type="submit" name="save">Відправити</button>
            </form>
        </div>
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="../js/jquery-3.4.1.min.js"></script>


<script type="text/javascript">


    $(document).ready(function() {

        const date=["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"];

        var id = 0;
        for(let device of id_array){
        let count = 0;
        for(let item of date){
            let i = 0;
            $(`#buttonAddRowOnOff_${device}_${item}`).click(function(e) {


                let elemRow = `
                    <div class="select-row_${device}_${item} clearfix">
                        <div style="display: inline-block"><label style="font-size: 14px;">Початок: </label><input class="form-control input-xs width-xs" type="time" step='1' value="08:00:00" name="valueOnOff['${device}']['time_values']['${item}']['start'][${i}]"> </div>
                        <div style="display: inline-block"><label>Кінець: </label><input class="form-control input-xs width-xs" type="time" step='1' value="09:00:00" name="valueOnOff['${device}']['time_values']['${item}']['end'][${i}]"> </div>
                        <div style="display: inline-block"><button class="button-delete-row_${device}_${item} button btn__del">X</button></div>
                    </div>`;

                e.preventDefault();
                $(elemRow).insertAfter(`.select-row_${device}_${item}:last`);
                i +=1;
                console.log(i);
            });
            $(`#buttonAddRowOnAuto_${device}_${item}`).click(function(e) {


                let elemRow = `
                    <div class="select-row_${device}_${item} clearfix">
                        <div style="display: inline-block"><label style="font-size: 14px;">Початок: </label><input class="form-control input-xs width-xs" type="time" step='1' value="08:00:00" name="valueOnAuto['${device}']['time_values']['${item}']['start'][${i}]"> </div>
                        <div style="display: inline-block"><button class="button-delete-row_${device}_${item} button btn_del">X</button></div>
                    </div>`;

                e.preventDefault();
                $(elemRow).insertBefore(`.select-row_${device}_${item}:last`);
                i +=1;
                console.log(i);
            });

            $(document).on('click', `.button-delete-row_${device}_${item}`, function(e) {
                e.preventDefault();
                $(this).closest(`.select-row_${device}_${item}`).remove();

            });

             }
            count += 1;
        }



    });

</script>

</body>
</html>