<?php
$type0_3 = generateData1($all_winds, 0.1, 3);
$type3_8 = generateData1($all_winds, 3.1, 8);
$type8_12 = generateData1($all_winds, 8.1, 12);
$type_more_12 = generateData1($all_winds, 12.1, 50);
?>

<script>
    var chartVars = "KoolOnLoadCallFunction=chartReadyHandler";

    KoolChart.create("chart1", "chartHolder", chartVars, "100%", "100%");

    function chartReadyHandler(id) {
        document.getElementById(id).setLayout(layoutStr);
        document.getElementById(id).setData(chartData);
    }

    var layoutStr =
        '<KoolChart backgroundColor="#FFFFFF"  borderStyle="none">'
        +'<Options>'
        +'<Caption text="Троянда вітрів" />'
        +'<SubCaption text="( m/c )" textAlign="right" />'
        +'<Legend defaultMouseOverAction="true" useVisibleCheck="true"/>'
        +'</Options>'
        +'<WindRoseChart showDataTips="true" dataTipDisplayMode="mouse" paddingBottom="30">'
        +'<angularAxis>'
        +'<CategoryAxis id="aAxis" categoryField="Direction"/>'
        +'</angularAxis>'
        +'<series>'

        +'<WindRoseSeries field="0-3m/c" displayName="0-3m/c">'
        +'<fill>'
        +'<SolidColor color="#9EFF00" alpha="0.8"/>'
        +'</fill>'
        +'<showDataEffect>'
        +'<SeriesInterpolate duration="1000"/>'
        +'</showDataEffect>'
        +'</WindRoseSeries>'

        +'<WindRoseSeries field="3-8m/c" displayName="3-8m/c">'
        +'<fill>'
        +'<SolidColor color="#FFE400" alpha="0.8"/>'
        +'</fill>'
        +'<showDataEffect>'
        +'<SeriesInterpolate duration="1000"/>'
        +'</showDataEffect>'
        +'</WindRoseSeries>'

        +'<WindRoseSeries field="8-12m/c" displayName="8-12m/c">'
        +'<fill>'
        +'<SolidColor color="#FF7800" alpha="0.8"/>'
        +'</fill>'
        +'<showDataEffect>'
        +'<SeriesInterpolate duration="1000"/>'
        +'</showDataEffect>'
        +'</WindRoseSeries>'

        +'<WindRoseSeries field=">=12m/c" displayName=">=12m/c">'
        +'<fill>'
        +'<SolidColor color="#FF3A00" alpha="0.8"/>'
        +'</fill>'
        +'<showDataEffect>'
        +'<SeriesInterpolate duration="1000"/>'
        +'</showDataEffect>'
        +'</WindRoseSeries>'

        +'</series>'
        +'<radialAxisRenderers>'
        +'<Axis2DRenderer axis="{aAxis}"/>'
        +'</radialAxisRenderers>'
        +'</WindRoseChart>'
        +'</KoolChart>';

    var chartData =
        [{"Direction":"Північний",">=12m/c": <?php echo $type_more_12[0]?>,"8-12m/c":<?php echo $type8_12[0]?>,"3-8m/c": <?php echo $type3_8[0]?>, "0-3m/c": <?php echo $type0_3[0]?>},
            {"Direction":"Пн-Сх",">=12m/c":<?php echo $type_more_12[1]?>,"8-12m/c":<?php echo $type8_12[1]?>,"3-8m/c":<?php echo $type3_8[1]?>, "0-3m/c": <?php echo $type0_3[1]?>},
            {"Direction":"Східний",">=12m/c":<?php echo $type_more_12[2]?>,"8-12m/c":<?php echo $type8_12[2]?>,"3-8m/c":<?php echo $type3_8[2]?>, "0-3m/c": <?php echo $type0_3[2]?>},
            {"Direction":"Пд-Сх",">=12m/c":<?php echo $type_more_12[3]?>,"8-12m/c":<?php echo $type8_12[3]?>,"3-8m/c":<?php echo $type3_8[3]?>, "0-3m/c": <?php echo $type0_3[3]?>},
            {"Direction":"Південний",">=12m/c":<?php echo $type_more_12[4]?>,"8-12m/c":<?php echo $type8_12[4]?>,"3-8m/c":<?php echo $type3_8[4]?>, "0-3m/c": <?php echo $type0_3[4]?>},
            {"Direction":"Пд-Зх",">=12m/c":<?php echo $type_more_12[5]?>,"8-12m/c":<?php echo $type8_12[5]?>,"3-8m/c":<?php echo $type3_8[5]?>, "0-3m/c": <?php echo $type0_3[5]?>},
            {"Direction":"Західний",">=12m/c":<?php echo $type_more_12[6]?>,"8-12m/c":<?php echo $type8_12[6]?>,"3-8m/c":<?php echo $type3_8[6]?>, "0-3m/c": <?php echo $type0_3[6]?>},
            {"Direction":"Пн-Зх",">=12m/c":<?php echo $type_more_12[7]?>,"8-12m/c":<?php echo $type8_12[7]?>,"3-8m/c":<?php echo $type3_8[7]?>, "0-3m/c": <?php echo $type0_3[7]?>}];

</script>
<div class="wind_add_wrapper">
   <p class="wind_add_h">Змінний вітер:</p>
        <ul>
            <li>0-3 m/c: <?php echo $type0_3[8]?></li>
            <li>3-8 m/c: <?php echo $type3_8[8]?></li>
            <li>8-12 m/c: <?php echo $type8_12[8]?></li>
            <li> =>12 m/c: <?php echo $type_more_12[8]?></li>
        </ul>
    <p class="wind_add_h">Штиль: </p>
    <p> 0 m/c: <?php echo sizeof($all_winds[9])?></p>
</div>
