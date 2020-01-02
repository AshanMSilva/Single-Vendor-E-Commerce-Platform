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
$products=$data[0];
$numAll=$data[1];
$period=$data[2];
?>
<!-- Styles -->
<style>
    
#chartdiv {
  width: 100%;
  height: 500px;
}

</style>

<!-- Resources -->
<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>

<!-- Chart code -->
<script>
am4core.ready(function() {
var products= <?php echo json_encode($products); ?>;
// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv", am4charts.XYChart);
var data=[];
for(let i = 0; i < products.length; i++){
    var product =products[i][0];
    var value =products[i][1];
    data.push({"country":product, "visits": value});
    }
// Add data
chart.data=data;

// Create axes

var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "country";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 30;

categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
  if (target.dataItem && target.dataItem.index & 2 == 2) {
    return dy + 25;
  }
  return dy;
});

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.dataFields.valueY = "visits";
series.dataFields.categoryX = "country";
series.name = "Visits";
series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
series.columns.template.fillOpacity = .8;

var columnTemplate = series.columns.template;
columnTemplate.strokeWidth = 2;
columnTemplate.strokeOpacity = 1;

}); // end am4core.ready()
</script>

<h1>Sales of Product by Period <?php echo "  ".$period; ?></h1>
<!-- HTML -->
<div id="chartdiv"></div>



<?php $this->end()?>