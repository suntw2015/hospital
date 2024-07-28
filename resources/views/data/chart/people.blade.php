<canvas id="peopleChart" width="200" height="100"></canvas>
<script>
$(function () {
    var randArray = function (min, max, size) {  
        // 创建一个空数组来存储结果  
        let res = [];  
        
        // 使用循环来填充数组  
        for (let i = 0; i < size; i++) {  
            // 生成一个介于min和max之间的随机整数（包括min和max）  
            let randomInt = Math.floor(Math.random() * (max - min + 1)) + min;  
            // 将生成的随机整数添加到数组中  
            res.push(randomInt);  
        }
        return res;
    } 

    var randSingle = function (min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    } 

    var config = {
        type: 'line',
        data: {
            labels: ['2024-01','2024-02','2024-03','2024-04','2024-05','2024-06','2024-07','2024-08','2024-09','2024-10','2024-11','2024-12'],
            datasets: [{
					label: '住院人数',
					backgroundColor: 'rgb(54, 162, 235)',
					borderColor: 'rgb(54, 162, 235)',
					data: randArray(1, 100, 12),
					fill: false,
				},{
					label: '手术人数',
					backgroundColor: 'rgb(255, 99, 132)',
					borderColor: 'rgb(255, 99, 132)',
					data: randArray(1, 100, 12),
					fill: false,
				},{
					label: '出院人数',
					backgroundColor: 'rgb(155, 205, 86)',
					borderColor: 'rgb(155, 205, 86)',
					data: randArray(1, 100, 12),
					fill: false,
				}]
        },
        options: {
            responsive: true,
				title: {
					display: true,
					text: '人数统计'
				},
				tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
				scales: {
					xAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: '日期'
						}
					}],
					yAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: '人数'
						}
					}]
				}
        }
    };

    var ctx = document.getElementById('peopleChart').getContext('2d');
    new Chart(ctx, config);
});
</script>