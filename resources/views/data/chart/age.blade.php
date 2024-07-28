<canvas id="ageChart" width="200" height="300"></canvas>
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
        type: 'doughnut',
        data: {
            datasets: [{
                data: randArray(1, 100, 6),
                backgroundColor: [
                    'rgb(54, 162, 235)',
                    'rgb(255, 99, 132)',
                    'rgb(54, 180, 32)',
                    'rgb(155, 205, 86)',
                    'rgb(78, 171, 28)',
                    'rgb(100, 100, 86)',
                ]
            }],
            labels: ['20-30岁','30-40岁','40-50岁','50-60岁','60-70岁','70岁以上',]
        },
        options: {
            // 例如，调整环形图的空心大小  
            cutoutPercentage: 50, // 环形图的空心大小，以百分比表示  
            rotation: 1 * Math.PI, // 环形图的起始角度（以弧度为单位）  
            circumference: 2 * Math.PI, // 环形图的显示弧长（以弧度为单位），设置为 2 * Math.PI 表示显示整个圆  
            legend: {  
                display: true, // 是否显示图例  
                position: 'left' // 图例的位置  
            },  
            responsive: true, // 图表是否响应式显示  
            maintainAspectRatio: false // 是否保持图表的宽高比
        }
    };

    var ctx = document.getElementById('ageChart').getContext('2d');
    new Chart(ctx, config);
});
</script>