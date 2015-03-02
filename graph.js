var width  = $("#chart-container").innerWidth();
var height = $("#chart-container").innerHeight()*1.5;

var data = [{x: 1421625600.000000, y: 13},{x: 1421626500.000000, y: 20},{x: 1421627400.000000, y: 18},{x: 1421628300.000000, y: 0},{x: 1421629200.000000, y: 14},{x: 1421630100.000000, y: 20},{x: 1421631000.000000, y: 18},{x: 1421631900.000000, y: 13},{x: 1421632800.000000, y: 14},{x: 1421633700.000000, y: 20},{x: 1421634600.000000, y: 18},{x: 1421635500.000000, y: 0},{x: 1421636400.000000, y: 14},{x: 1421637300.000000, y: 20},{x: 1421638200.000000, y: 18},{x: 1421639100.000000, y: 13},{x: 1421640000.000000, y: 14},{x: 1421640900.000000, y: 20},{x: 1421641800.000000, y: 18},{x: 1421642700.000000, y: 13},{x: 1421643600.000000, y: 14},{x: 1421644500.000000, y: 20},{x: 1421645400.000000, y: 18},{x: 1421646300.000000, y: 13},{x: 1421647200.000000, y: 14},{x: 1421648100.000000, y: 20},{x: 1421649000.000000, y: 18},{x: 1421649900.000000, y: 13},{x: 1421650800.000000, y: 14},{x: 1421651700.000000, y: 20},{x: 1421652600.000000, y: 18},{x: 1421653500.000000, y: 0},{x: 1421654400.000000, y: 14},{x: 1421655300.000000, y: 20},{x: 1421656200.000000, y: 18},{x: 1421657100.000000, y: 13},{x: 1421658000.000000, y: 14},{x: 1421658900.000000, y: 20},{x: 1421659800.000000, y: 18},{x: 1421660700.000000, y: 13},{x: 1421661600.000000, y: 14},{x: 1421662500.000000, y: 20},{x: 1421663400.000000, y: 18},{x: 1421664300.000000, y: 13},{x: 1421665200.000000, y: 14},{x: 1421666100.000000, y: 20},{x: 1421667000.000000, y: 18},{x: 1421667900.000000, y: 13},{x: 1421668800.000000, y: 14},{x: 1421669700.000000, y: 20},{x: 1421670600.000000, y: 18},{x: 1421671500.000000, y: 0},{x: 1421672400.000000, y: 14},{x: 1421673300.000000, y: 20},{x: 1421674200.000000, y: 18},{x: 1421675100.000000, y: 13},{x: 1421676000.000000, y: 14},{x: 1421676900.000000, y: 20},{x: 1421677800.000000, y: 18},{x: 1421678700.000000, y: 13},{x: 1421679600.000000, y: 14},{x: 1421680500.000000, y: 20},{x: 1421681400.000000, y: 18},{x: 1421682300.000000, y: 13},{x: 1421683200.000000, y: 14},{x: 1421684100.000000, y: 20},{x: 1421685000.000000, y: 18},{x: 1421685900.000000, y: 13},{x: 1421686800.000000, y: 14},{x: 1421687700.000000, y: 20},{x: 1421688600.000000, y: 18},{x: 1421689500.000000, y: 13},{x: 1421690400.000000, y: 14},{x: 1421691300.000000, y: 20},{x: 1421692200.000000, y: 18},{x: 1421693100.000000, y: 13},{x: 1421694000.000000, y: 14},{x: 1421694900.000000, y: 20},{x: 1421695800.000000, y: 18},{x: 1421696700.000000, y: 0},{x: 1421697600.000000, y: 14},{x: 1421698500.000000, y: 20},{x: 1421699400.000000, y: 18},{x: 1421700300.000000, y: 13},{x: 1421701200.000000, y: 14},{x: 1421702100.000000, y: 16},{x: 1421703000.000000, y: 14},{x: 1421703900.000000, y: 15},{x: 1421704800.000000, y: 14},{x: 1421705700.000000, y: 14},{x: 1421706600.000000, y: 13},{x: 1421707500.000000, y: 16},{x: 1421708400.000000, y: 19},{x: 1421709300.000000, y: 20},{x: 1421710200.000000, y: 18},{x: 1421711100.000000, y: 0},];
var graph = new Rickshaw.Graph( {
	width: width,
	height:height,
	interpolation: 'linear',
	element: document.getElementById("chart"),
	renderer: 'line',
	padding: { top: 0.1 },
	series: [
		{
			color: "steelblue",
			data: data,
			name: 'BPM'
		}
	]
} );

var time = new Rickshaw.Fixtures.Time();
var hours = time.unit('hour');

var x_ticks = new Rickshaw.Graph.Axis.Time( {
	graph: graph,
	timeUnit: hours
} );
var y_ticks = new Rickshaw.Graph.Axis.Y( {
	graph: graph,
	orientation: 'left',
	tickFormat: Rickshaw.Fixtures.Number.formatKMBT,
	element: document.getElementById('y_axis')
} );

var preview = new Rickshaw.Graph.RangeSlider.Preview( {
	graph: graph,
	element: document.getElementById('preview'),
} );

var annotator = new Rickshaw.Graph.Annotate({
    graph: graph,
    element: document.getElementById('timeline')
});

annotator.add(1421628300, '00:45 - Event #1   Duration:25 sec'); //00:45
annotator.add(1421635500, '02:45 - Event #2   Duration:15 sec'); //02:45
annotator.add(1421653500, '07:45 - Event #3   Duration:11 sec'); //07:45
annotator.add(1421671500, '12:45 - Event #4   Duration:18 sec'); //12:45
annotator.add(1421696700, '19:45 - Event #5   Duration:23 sec'); //19:45
annotator.add(1421711100, '23:45 - Event #6   Duration:10 sec'); //23:45
annotator.update();

graph.render();



var legend = document.querySelector('#legend');

var Hover = Rickshaw.Class.create(Rickshaw.Graph.HoverDetail, {

	render: function(args) {

		legend.innerHTML = args.formattedXValue;

		args.detail.sort(function(a, b) { return a.order - b.order }).forEach( function(d) {

			var line = document.createElement('div');
			line.className = 'line';

			var swatch = document.createElement('div');
			swatch.className = 'swatch';
			swatch.style.backgroundColor = d.series.color;

			var label = document.createElement('div');
			label.className = 'label';
			label.innerHTML = d.name + ": " + d.formattedYValue;

			line.appendChild(swatch);
			line.appendChild(label);

			legend.appendChild(line);

			var dot = document.createElement('div');
			dot.className = 'dot';
			dot.style.top = graph.y(d.value.y0 + d.value.y) + 'px';
			dot.style.borderColor = '#F00';

			this.element.appendChild(dot);

			dot.className = 'dot active';

			this.show();

		}, this );
        }
});

var hover = new Hover( { graph: graph } );

//*
$(window).on('resize',resize);


function resize() {
  graph.configure({
    width: $("#chart-container").innerWidth(),
  });
  graph.render();

}
//*/
