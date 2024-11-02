<style>
	.header {
		border-bottom: 1px double #e86100;
		width: 100%;
		height: 60px;
		margin-top: 0px;
	}

	.header h3 {
		margin-top: 0;
		margin-bottom: 5px;
		font-size: 40px;
		font-weight: bold;
		font-style: italic;
		text-align: center;
		color: #a30bf1;
	}

	.img {
		height: 120px;
		margin-top: 0px;
	}

	.section3 {
		height: 130px;
	}

	.section4 {
		height: 130px;
		margin-bottom: 15px;
	}

	.section12 {
		height: 110px;
		width: 100%;
		margin-top: 5px;
		border-radius: 5px;
	}

	.section12 .logo {
		height: 30px;
		width: 100%;
		font-size: 40px;
		text-align: center;
		margin-top: 5px;
	}

	.section12 .textModule {
		height: auto;
		width: 100%;
		margin-top: 20px;
		font-weight: bold;
		font-size: 14px;
		color: #000;
		text-align: center;
	}

	.section122 {
		height: 130px;
		width: 100%;
		margin-top: 5px;
		border-radius: 5px;
		background-color: #A7ECFB;
		border: 1px solid #ccc;
	}

	.section122 .logo {
		height: 75px;
		width: 100%;
		font-size: 60px;
		text-align: center;
		margin-top: 5px;
	}

	.section122 .textModule {
		height: auto;
		width: 100%;
		margin-top: 15px;
		font-weight: bold;
		font-size: 17px;
		color: #000;
		text-align: center;
	}

	.section20 {
		height: 90px;
		width: 100%;
		margin-top: 20px;
		border-radius: 5px;
	}

	.section20 .logo {
		height: 50px;
		width: 100%;
		font-size: 40px;
		text-align: center;
		margin-top: 5px;
		color: #FFF;
	}

	.section20 .textModule {
		height: auto;
		width: 100%;
		margin-top: 10px;
		font-weight: bold;
		font-size: 12px;
		color: #f5f5f5;
		text-align: center;
	}

	.img {
		height: 100px;
		margin-top: 10px;
		/*border: 1px solid;*/
	}

	.txtBody {
		height: auto;
		width: 100%;
		margin-top: 5px;
		font-weight: bold;
		font-size: 70px;
		color: #1A7EB0;
		text-align: center;
	}

	a {
		color: #333;
	}

	.module_title {
		background-color: #00BE67 !important;
		text-align: center;
		font-size: 18px !important;
		font-weight: bold;
		font-style: italic;
		color: #fff !important;
	}

	.section12,
	.section20 {
		background: -webkit-linear-gradient(to right, #337ab7, #5a4692);
		/* background: linear-gradient(to right, #337ab7, #5a4692); */
		background: #A7ECFB;
	}

	.section12,
	.section20 a .logo {
		color: #000 !important;
	}

	.section12,
	.section20 a .textModule {
		color: #000 !important;
		font-size: 12px !important;
	}



	.ImageBackground {
		display: flex;
		flex-direction: column;
		align-items: center;
	}

	.ImageBackground .imageShow {
		display: block;
		height: 105px;
		width: 115px;
		border: 1px solid #cccccc;
		box-sizing: border-box;
		margin-bottom: 5px;
	}

	.ImageBackground input {
		display: none;
	}

	.ImageBackground label {
		background: #41add6;
		width: 115px;
		color: white;
		padding: 0 5px;
		text-align: center;
		cursor: pointer;
		font-family: monospace;
		text-transform: uppercase;
		border-radius: 3px;
	}

	/* v-select sytle */

	.v-select {
		margin-bottom: 5px;
	}

	.v-select .dropdown-toggle {
		padding: 0px;
		height: 25px;
	}

	.v-select input[type=search],
	.v-select input[type=search]:focus {
		margin: -2.5px !important;
	}

	.v-select .vs__selected-options {
		overflow: hidden;
		flex-wrap: nowrap;
	}

	.v-select .selected-tag {
		margin: 10px 2px !important;
		white-space: nowrap;
		position: absolute;
		left: 0px;
		top: 0;
		line-height: 0px !important;
	}

	.v-select .dropdown-menu {
		width: auto;
		overflow-y: auto;
	}

	/* toastr style */
	#toast-container .toast {
		opacity: 1 !important;
		box-shadow: none !important;
	}


	/* preloader */
	.preloader {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background-color: #fff;
		display: flex;
		justify-content: center;
		align-items: center;
		z-index: 1000;
	}

	.preloader img {
		width: 100px;
		height: auto;
	}

	/* due message */
	.cards {
		background: red;
		padding: 5px;
	}

	@media (min-width:320px) and (max-width:620px) {
		.section122 .textModule {
			font-size: 12px !important;
		}

		.header {
			border-bottom: 1px double #e86100;
			width: 100%;
			height: 35px !important;
			margin-top: 0px;
			margin: 0 !important;
		}

		.header h3 {
			margin-top: 0;
			margin-bottom: 3px;
			font-size: 25px !important;
			font-weight: bold;
			font-style: italic;
			text-align: center;
			color: #a30bf1;
		}

		.headerForDash {
			border-bottom: 1px double #e86100;
			width: 100%;
			height: 118px !important;
			margin-top: 0px;
			margin-bottom: 10px !important;
		}

		.headerForDash h3 {
			border-bottom: 1px double #e86100;
			width: 100%;
			height: 130px !important;
			margin-top: 0px;
		}
	}
</style>