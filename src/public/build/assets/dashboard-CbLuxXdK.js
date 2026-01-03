import{l as u,m as C,p as S,q as E,s as f}from"./vue-kMPmmKrw.js";const m={name:"Trending",props:{value:{type:Number,default:25},className:{type:String,default:""}},setup(e){const s=u(()=>e.value>0?"green":e.value===0?"muted":"red"),t=u(()=>e.value>0?"arrow-up":e.value===0?"minus":"arrow-down"),l=u(()=>({"arrow-up":"M3 17l6 -6l4 4l8 -8 M14 7l7 0l0 7",minus:"M5 12l14 0","arrow-down":"M3 7l6 6l4 -4l8 8 M21 10l0 7l-7 0"})[t.value]);return{trendingColor:s,trendingIcon:t,iconPath:l}},template:`
        <span :class="['text-' + trendingColor, 'd-inline-flex', 'align-items-center', 'lh-1', className]">
            {{ value }}%
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="icon icon-sm ms-1"
                 width="24"
                 height="24"
                 viewBox="0 0 24 24"
                 stroke-width="2"
                 stroke="currentColor"
                 fill="none"
                 stroke-linecap="round"
                 stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path :d="iconPath"/>
            </svg>
        </span>
    `},p={name:"StatsCard",props:{title:{type:String,required:!0},value:{type:[String,Number],required:!0},trend:{type:Number,default:0},description:{type:String,default:""},chartData:{type:Array,default:()=>[]}},setup(e){const s=u(()=>e.trend>0?"green":e.trend===0?"muted":"red"),t=u(()=>e.trend>0?"arrow-up":e.trend===0?"minus":"arrow-down"),l=u(()=>({"arrow-up":"M3 17l6 -6l4 4l8 -8 M14 7l7 0l0 7",minus:"M5 12l14 0","arrow-down":"M12 5l0 14 M18 13l-6 6 M6 13l6 6"})[t.value]),d=u(()=>typeof e.value=="number"?e.value.toLocaleString():e.value);return{trendingColor:s,trendingIcon:t,iconPath:l,formattedValue:d}},template:`
            <div>
                <div class="subheader">{{ title }}</div>
                <div class="d-flex align-items-baseline">
                    <div class="h1 mb-0 me-2">{{ formattedValue }}</div>
                    <div class="me-auto">
                        <span :class="['text-' + trendingColor, 'd-inline-flex', 'align-items-center', 'lh-1']">
                            {{ trend }}%
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="icon icon-sm ms-1"
                                 width="24"
                                 height="24"
                                 viewBox="0 0 24 24"
                                 stroke-width="2"
                                 stroke="currentColor"
                                 fill="none"
                                 stroke-linecap="round"
                                 stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path :d="iconPath"/>
                            </svg>
                        </span>
                    </div>
                </div>
                <div v-if="description" class="text-secondary mt-2">{{ description }}</div>
            </div>
    `},V="modulepreload",M=function(e){return"/build/"+e},v={},P=function(s,t,l){let d=Promise.resolve();if(t&&t.length>0){document.getElementsByTagName("link");const r=document.querySelector("meta[property=csp-nonce]"),n=(r==null?void 0:r.nonce)||(r==null?void 0:r.getAttribute("nonce"));d=Promise.allSettled(t.map(a=>{if(a=M(a),a in v)return;v[a]=!0;const h=a.endsWith(".css"),k=h?'[rel="stylesheet"]':"";if(document.querySelector(`link[href="${a}"]${k}`))return;const o=document.createElement("link");if(o.rel=h?"stylesheet":V,h||(o.as="script"),o.crossOrigin="",o.href=a,n&&o.setAttribute("nonce",n),document.head.appendChild(o),h)return new Promise((x,A)=>{o.addEventListener("load",x),o.addEventListener("error",()=>A(new Error(`Unable to preload CSS for ${a}`)))})}))}function c(r){const n=new Event("vite:preloadError",{cancelable:!0});if(n.payload=r,window.dispatchEvent(n),!n.defaultPrevented)throw r}return d.then(r=>{for(const n of r||[])n.status==="rejected"&&c(n.reason);return s().catch(c)})},b={name:"ApexChart",props:{chartId:{type:String,required:!0},type:{type:String,default:"bar"},height:{type:Number,default:10},series:{type:Array,required:!0},options:{type:Object,default:()=>({})},sparkline:{type:Boolean,default:!1},stacked:{type:Boolean,default:!1}},setup(e){const s=C(null);let t=null;const l={chart:{type:e.type,fontFamily:"inherit",height:e.height,parentHeightOffset:0,toolbar:{show:!1},animations:{enabled:!1},sparkline:{enabled:e.sparkline},stacked:e.stacked},dataLabels:{enabled:!1},stroke:{width:2,lineCap:"round",curve:"smooth"},tooltip:{theme:"dark"},grid:{padding:{top:-20,right:0,left:-4,bottom:-4},strokeDashArray:4},xaxis:{labels:{padding:0},tooltip:{enabled:!1},axisBorder:{show:!1}},yaxis:{labels:{padding:4}},legend:{show:!1},colors:["var(--tblr-primary)","var(--tblr-success)","var(--tblr-info)"]},d=async()=>{if(!s.value)return;const r=(await P(async()=>{const{default:a}=await import("./apexcharts-zneQmw8d.js").then(h=>h.a);return{default:a}},[])).default,n={...l,...e.options,chart:{...l.chart,...e.options.chart||{}}};t=new r(s.value,{...n,series:e.series}),t.render()},c=()=>{t&&t.updateOptions({...e.options,series:e.series})};return S(()=>{d()}),E(()=>{t&&t.destroy()}),f(()=>e.series,c,{deep:!0}),f(()=>e.options,c,{deep:!0}),{chartElement:s}},template:`
        <div :id="'chart-' + chartId" ref="chartElement" class="chart"></div>
    `},i=window.dashboardData||{};var g;window.createVueApp(m,{value:((g=i.trends)==null?void 0:g.positive)??7}).mount("#trending-positive");var w;window.createVueApp(m,{value:((w=i.trends)==null?void 0:w.negative)??-1}).mount("#trending-negative");var y;window.createVueApp(m,{value:((y=i.trends)==null?void 0:y.activeUsers)??-1}).mount("#trending-active-users");window.createVueApp(p,{title:"Total Users",value:i.totalUsers??75782,trend:2,description:"24,635 users increased from last month"}).mount("#stats-total-users");window.createVueApp(p,{title:"Revenue",value:i.revenue??"$128,320",trend:12,description:"+$15,240 from last week"}).mount("#stats-revenue");window.createVueApp(p,{title:"Orders",value:i.orders??2456,trend:-3,description:"128 orders decreased"}).mount("#stats-orders");document.getElementById("chart-active-users")&&window.createVueApp(b,{chartId:"active-users",type:"radialBar",height:192,series:[i.activeUsersPercentage??78],options:{chart:{fontFamily:"inherit",sparkline:{enabled:!0},animations:{enabled:!1}},plotOptions:{radialBar:{startAngle:-120,endAngle:120,hollow:{margin:16,size:"50%"},dataLabels:{show:!0,value:{offsetY:-8,fontSize:"24px"}}}},labels:[""],tooltip:{theme:"dark"},grid:{strokeDashArray:4},colors:["color-mix(in srgb, transparent, var(--tblr-primary) 100%)"],legend:{show:!1}}}).mount("#chart-active-users");document.getElementById("chart-visitors")&&window.createVueApp(b,{chartId:"visitors",type:"line",height:96,series:[{name:"Visitors",data:i.visitorsData??[7687,7543,7545,7543,7635,8140,7810,8315,8379,8441,8485,8227,8906,8561,8333,8551,9305,9647,9359,9840,9805,8612,8970,8097,8070,9829,10545,10754,10270,9282]},{name:"Visitors last month",data:i.visitorsLastMonthData??[8630,9389,8427,9669,8736,8261,8037,8922,9758,8592,8976,9459,8125,8528,8027,8256,8670,9384,9813,8425,8162,8024,8897,9284,8972,8776,8121,9476,8281,9065]}],options:{chart:{fontFamily:"inherit",sparkline:{enabled:!0},animations:{enabled:!1}},stroke:{width:[2,1],dashArray:[0,3],lineCap:"round",curve:"smooth"},tooltip:{theme:"dark"},grid:{strokeDashArray:4},xaxis:{labels:{padding:0},tooltip:{enabled:!1},type:"datetime"},yaxis:{labels:{padding:4}},labels:["2020-06-21","2020-06-22","2020-06-23","2020-06-24","2020-06-25","2020-06-26","2020-06-27","2020-06-28","2020-06-29","2020-06-30","2020-07-01","2020-07-02","2020-07-03","2020-07-04","2020-07-05","2020-07-06","2020-07-07","2020-07-08","2020-07-09","2020-07-10","2020-07-11","2020-07-12","2020-07-13","2020-07-14","2020-07-15","2020-07-16","2020-07-17","2020-07-18","2020-07-19","2020-07-20"],colors:["color-mix(in srgb, transparent, var(--tblr-primary) 100%)","color-mix(in srgb, transparent, var(--tblr-gray-400) 100%)"],legend:{show:!1}}}).mount("#chart-visitors");
