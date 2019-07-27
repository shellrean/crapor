<style>
	@import url('https://fonts.googleapis.com/css?family=Special+Elite');
	blockquote {
	font-weight: 100;
	font-size: 1.5rem;
	max-width: 600px;
	line-height: 1.4;
	position: relative;
	margin: 0;
	padding: .5rem;
	}

	blockquote:before,
	blockquote:after {
		position: absolute;
		color: #f1efe6;
		font-size: 8rem;
		width: 4rem;
		height: 4rem;
	}

	blockquote:before {
		content: '“';
		left: -5rem;
		top: -2rem;
	}

	blockquote:after {
		content: '”';
		right: -5rem;
		bottom: 1rem;
	}

	cite {
		line-height: 3;
		text-align: left;
	}
	.bg {
		font-family: 'Special Elite', cursive;
		background: #fffdf5;
		color: #3f3f5a;
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
	}
</style>

<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-header py-3">
          For my teachers
        </div>
        <div class="card-body">
        	<div class="text-left">
        		<table>
        			<tr>
        				<td>
        					<img src="<?= base_url() ?>assets/img/dll/teac.svg" width="200px">
        				</td>
        				<td>
		        		<div class="bg">
		        			<blockquote>Thank you for being so patient, and helping me improve! Teachers like you are hard to find, and I’m eternally grateful for everything you’ve taught me.</blockquote>
							<cite>Developer</cite>
		        		</div>
        		
        				</td>
        			</tr>
        		</table>
	        </div>
        </div>
    </div>
</div> 