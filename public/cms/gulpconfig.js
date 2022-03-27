module.exports = {

	path: {

		destination:{
			css: 'dist/css',
			js: 'dist/js',
		},

		css:{
			vendor: [
				'node_modules/bootstrap/dist/css/bootstrap.min.css',
				'node_modules/ionicons/css/ionicons.min.css',
				'node_modules/font-awesome/css/font-awesome.min.css',
				'node_modules/pace-js/themes/pink/pace-theme-flash.css',				
				'node_modules/datatables.net-bs/css/dataTables.bootstrap.min.css',
				'node_modules/summernote/dist/summernote-bs4.css',
				'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
				'node_modules/select2/dist/css/select2.min.css',
				'node_modules/bootstrap-toggle/css/bootstrap-toggle.min.css',
				'node_modules/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
				//'node_modules/spectrum-colorpicker/spectrum.css',
			],
			app: [
				'src/lte/css/AdminLTE.min.css',
				'src/lte/css/skins/_all-skins.min.css',
				'src/lte/css/custom.css',
			],
			login: [
				'node_modules/bootstrap/dist/css/bootstrap.min.css',
				'node_modules/ionicons/css/ionicons.min.css',
				'node_modules/font-awesome/css/font-awesome.min.css',
				'src/lte/css/AdminLTE.min.css',
			]
		},

		js:{
			login:[
				"node_modules/jquery/dist/jquery.min.js",
				"node_modules/bootstrap/dist/js/bootstrap.min.js",
			],
			app: [
				'src/lte/js/adminlte.js',
				'src/js/custom.js',
			],
			vendor: [
				"node_modules/jquery/dist/jquery.min.js",
				"node_modules/bootstrap/dist/js/bootstrap.min.js",
				"node_modules/moment/min/moment.min.js",
				"node_modules/pace-js/pace.min.js",
				"node_modules/parsleyjs/dist/parsley.min.js",
				"node_modules/datatables.net/js/jquery.dataTables.min.js",
				"node_modules/datatables.net-bs/js/dataTables.bootstrap.min.js",
				"node_modules/summernote/dist/summernote.min.js",
				"node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js",
				'node_modules/select2/dist/js/select2.min.js',
				'node_modules/bootstrap-toggle/js/bootstrap-toggle.min.js',
				'node_modules/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
				'node_modules/xlsx/dist/xlsx.full.min.js',
				'node_modules/file-saver/dist/FileSaver.min.js',
				
				/* "node_modules/jquery-ui",
				"node_modules/jquery-ui/ui/widgets/sortable.js",
				"select2",
				"spectrum-colorpicker", */
			],
		},

		app_file:[
			{				
				source: 'src/img/**/*',
				destination: 'dist/img'
			}
		],

		vendor_file:[
			{
				source: 'node_modules/font-awesome/fonts/**/*',
				destination: 'dist/fonts'
			},
			{
				source: 'node_modules/bootstrap/dist/fonts/**/*',
				destination: 'dist/fonts'
			},
			{
				source: 'node_modules/summernote/dist/font/**/*',
				destination: 'dist/css/font'
			},
		]
	},


	name: {
		css:{
			app: 'app.min.css',
			login: 'login.min.css',
			vendor: 'vendor.min.css',
		},
		js: {
		  	app: 'app.min.js',
			vendor: 'vendor.min.js',
			login: 'login.min.js',
		}
	}
};
