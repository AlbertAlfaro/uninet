console.log(productos);
!function(e){
    var t={};
    function r(a){if(t[a])return t[a].exports;var o=t[a]={i:a,l:!1,exports:{}};
    return e[a].call(o.exports,o,o.exports,r),o.l=!0,o.exports}r.m=e,r.c=t,r.d=function(e,t,a){r.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:a})},r.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},r.t=function(e,t){if(1&t&&(e=r(e)),8&t)return e;
        if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var a=Object.create(null);
        if(r.r(a),Object.defineProperty(a,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)r.d(a,o,function(t){return e[t]}.bind(null,o));
        return a},r.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};

        return r.d(t,"a",t),t},r.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},r.p="/",r(r.s=10)

    }({10:function(e,t,r){e.exports=r(11)},11:function(e,t){new ApexCharts(document.querySelector("#total-revenue-chart"),{series:[{data:[25,66,41,89,63,25,44,20,36,40,54]}],fill:{colors:["#5b73e8"]},chart:{type:"bar",width:70,height:40,sparkline:{enabled:!0}},plotOptions:{bar:{columnWidth:"50%"}},labels:[1,2,3,4,5,6,7,8,9,10,11],xaxis:{crosshairs:{width:1}},tooltip:{fixed:{enabled:!1},x:{show:!1},y:{title:{formatter:function(e){return""}}},marker:{show:!1}}}).render();
        
        var r={fill:{colors:["#34c38f"]},series:[70],chart:{type:"radialBar",width:45,height:45,sparkline:{enabled:!0}},dataLabels:{enabled:!1},plotOptions:{radialBar:{hollow:{margin:0,size:"60%"},track:{margin:0},dataLabels:{show:!1}}}}; 
        new ApexCharts(document.querySelector("#orders-chart"),r).render();
        r={fill:{colors:["#5b73e8"]},series:[55],chart:{type:"radialBar",width:45,height:45,sparkline:{enabled:!0}},dataLabels:{enabled:!1},plotOptions:{radialBar:{hollow:{margin:0,size:"60%"},track:{margin:0},dataLabels:{show:!1}}}};
        new ApexCharts(document.querySelector("#customers-chart"),r).render();
        new ApexCharts(document.querySelector("#growth-chart"),{series:[{data:[25,66,41,89,63,25,44,12,36,9,54]}],fill:{colors:["#f1b44c"]},chart:{type:"bar",width:70,height:40,sparkline:{enabled:!0}},plotOptions:{bar:{columnWidth:"50%"}},labels:[1,2,3,4,5,6,7,8,9,10,11],xaxis:{crosshairs:{width:1}},tooltip:{fixed:{enabled:!1},x:{show:!1},y:{title:{formatter:function(e){return""}}},marker:{show:!1}}}).render();
        r={chart:{height:339,type:"line",stacked:!1,toolbar:{show:!1}},stroke:{width:[0,2,4],curve:"smooth"},plotOptions:{bar:{columnWidth:"30%"}},colors:["#5b73e8","#dfe2e6","#f1b44c"],series:[{name:"Internet",type:"column",data: datos_inter},{name:"Televisi??n",type:"area",data:datos_tv},{name:"Productos",type:"line",data:productos}],fill:{opacity:[.85,.25,1],gradient:{inverseColors:!1,shade:"light",type:"vertical",opacityFrom:.85,opacityTo:.55,stops:[0,100,100,100]}},labels: fechas ,markers:{size:0},xaxis:{type:"datetime"},yaxis:{ labels:{ formatter: function(val){ return "$ "+val.toFixed(2);}, }, title:{text:"Dolares"}},tooltip:{shared:!0,intersect:!1,y:{formatter:function(e){return void 0!==e?"$ "+e.toFixed(2):e}}},grid:{borderColor:"#f1f1f1"}};
        new ApexCharts(document.querySelector("#sales-analytics-chart"),r).render()}
    
    });