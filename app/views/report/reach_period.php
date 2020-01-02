<?php $this->start('head')?>



<style>
#chartdiv {
  width: 100%;
  height: 500px;
}
</style>

<?php $this->end()?>

<?php $this->start('body')?>

<?php $data=$this->get_data();

// dnd($data);?>
<!-- Resources -->
<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>

<!-- Chart code -->
<script type="text/javascript">
        var dates=<?php echo json_encode($data); ?>;
            // console.log(dates);
          am4core.ready(function() {

          // Themes begin
          am4core.useTheme(am4themes_animated);
          // Themes end

          var chart = am4core.create("chartdiv", am4charts.XYChart);
          
          var data=[];
          for(let i = 0; i < dates.length; i++){
            var year=dates[i][0][0];
            var month=dates[i][0][1];
            var day=dates[i][0][2];  
            let date = new Date(year,month,day);
            var value=dates[i][1];
            // date.setHours(0,0,0,0);
            // date.setDate(i);
            // value -= Math.round((Math.random() < 0.5 ? 1 : -1) * Math.random() * 10);
            // value=5
            data.push({date:date, value: value});
          }
          // for(let i=0; i<300;i++){
          //   data.push(i , 2*i );
          // }

          chart.data = data;

          // Create axes
          var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
          dateAxis.renderer.minGridDistance = 60;

          var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

          // Create series
          var series = chart.series.push(new am4charts.LineSeries());
          series.dataFields.valueY = "value";
          series.dataFields.dateX = "date";
          series.tooltipText = "{value}"

          series.tooltip.pointerOrientation = "vertical";

          chart.cursor = new am4charts.XYCursor();
          chart.cursor.snapToSeries = series;
          chart.cursor.xAxis = dateAxis;

          //chart.scrollbarY = new am4core.Scrollbar();
          chart.scrollbarX = new am4core.Scrollbar();

          }); // end am4core.ready()
    
</script>
<h1>Product's Interest with Time</h1>
<h5>Income (Dollars)</h5>
<!-- HTML -->
<h3 class="mb-30">Product's Interest with Time</h3>
<div id="chartdiv"></div>


<?php $this->end()?>