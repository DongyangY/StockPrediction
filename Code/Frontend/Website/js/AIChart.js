google.load('visualization', '1', {'packages':['annotationchart']});
google.setOnLoadCallback(loadWindow());

function loadWindow() {
	getdata0(0);
}

function getdata0(symbolId) {
  //alert("getdata");
  $.getJSON(
    "backend/jsonsender_AI.php", // The s/erver URL
    {id: symbolId},
    showdata0 // The function to call on completion.
  );
}


function showdata0(json){  

  
  
  var dataLength = 200;
	
  var date2;
  var dateParts2;
  var jsDate2;
  var data2 = new google.visualization.DataTable();
  data2.addColumn('date', 'Date');
  data2.addColumn('number', 'Bayesian');
  data2.addColumn('number', 'STS');
  data2.addColumn('number', 'SVM');
  data2.addColumn('number', 'ANN');
  
  for (var i = dataLength - 1; i >= 0; i--){
    date2 = json[i].Date;
    dateParts2 = date2.split("-");
    jsDate2 = new Date(dateParts2[0], dateParts2[1] - 1, dateParts2[2]);
    data2.addRows([
      [jsDate2, parseFloat(json[i].Total), parseFloat(json[i + dataLength].Total), parseFloat(json[i + dataLength * 2].Total), parseFloat(json[i + dataLength * 3].Total)],
    ]);
  }

  var chart2 = new google.visualization.AnnotationChart(document.getElementById('chart_div5'));

  var options = {
    displayAnnotations: false,
    displayExactValues : true,
    displayRangeSelector : true,
    thickness : 1.5,
    displayLegendDots : true,
    colors : ['#1a3c75','#E26D26', '#FF66FF', '#0000FF', '#9900FF'],
  };

  chart2.draw(data2, options);
   
}

   