import{X as G,P as T,J as P,c as M,d as a,w as t,F as q,r as i,o as u,j as m,g as s,t as O,v as L,I as D,i as y,h as _,f as J}from"./app-af2088fa.js";import{_ as W}from"./AuthenticatedLayout-cb5bc9f2.js";import{_ as X}from"./_plugin-vue_export-helper-c27b6911.js";const z={inject:["validateMessages"],components:{AuthenticatedLayout:W,Head:G},props:{employee:Object,errors:Object},setup(l){const e={labelCol:{span:8},wrapperCol:{span:16}},v=T({salary_type:l.employee.salarydetail!=null?l.employee.salarydetail.salary_type:"Month",salary_amount:l.employee.salarydetail!=null?l.employee.salarydetail.salary_amount:"",allowances:l.employee.salarydetail!=null?l.employee.salarydetail.allowances:{},pf_detail:l.employee.salarydetail!=null?l.employee.salarydetail.pf_detail:"",esi_detail:l.employee.salarydetail!=null?l.employee.salarydetail.esi_detail:"",pf_amount:l.employee.salarydetail!=null?l.employee.salarydetail.pf_amount:"",esi_amount:l.employee.salarydetail!=null?l.employee.salarydetail.esi_amount:"",ctc:l.employee.salarydetail!=null?l.employee.salarydetail.ctc:""}),o=T({weekoff_pay:l.employee.otsettings!=null?l.employee.otsettings.weekoff_pay:"0",publicholiday_pay:l.employee.otsettings!=null?l.employee.otsettings.publicholiday_pay:"0",extra_hours_pay:l.employee.otsettings!=null?l.employee.otsettings.extra_hours_pay:"0",grace_period:l.employee.otsettings!=null?l.employee.otsettings.grace_period:""}),f=T({allowed_days:l.employee.latepenalty_setting!=null?l.employee.latepenalty_setting.allowed_days:"",grace_period:l.employee.latepenalty_setting!=null?l.employee.latepenalty_setting.grace_period:"",deduction_type:l.employee.latepenalty_setting!=null?l.employee.latepenalty_setting.deduction_type:"",deduction_rate:l.employee.latepenalty_setting!=null?l.employee.latepenalty_setting.deduction_rate:""});return{formState:v,OtformState:o,LateformState:f,layout:e}},data(){return{otdrawer_visible:!1,latedrawer_visible:!1}},methods:{addAllowances(l){this.formState.allowances[l]=""},removeAllowance(l){delete this.formState.allowances[l]},submit(){this.formState.post(route("employees.update_salary_info",this.employee.id))},calcCTC(){if(this.formState.salary_type=="Day"||this.formState.salary_type=="Hour")this.formState.ctc=this.formState.salary_amount;else{var l=0,e=0,v=0;l+=parseInt(this.formState.salary_amount);var o=Object.values(this.formState.allowances).reduce((f,r)=>r==""?f:parseInt(f)+parseInt(r),0);l+=parseInt(o),this.formState.pf_detail=="2"?e=this.formState.salary_amount*(12/100):this.formState.pf_detail=="1"&&(e=this.formState.salary_amount*(12/100),e=e<=1800?e:1800),l-=parseInt(e),this.formState.esi_detail=="1"&&(v=this.formState.salary_amount*(.75/100)),l-=parseInt(v),this.formState.pf_amount=Math.round(e),this.formState.esi_amount=Math.round(v),this.formState.ctc=Math.round(l)}},OTsubmit(){P.post(route("employees.update_ot_info",this.employee.id),this.OtformState,{onSuccess:l=>{},onError:l=>{},onFinish:l=>{this.otdrawer_visible=!1}})},lateSubmit(){P.post(route("employees.update_latepenalty_info",this.employee.id),this.LateformState,{onSuccess:l=>{},onError:l=>{},onFinish:l=>{this.latedrawer_visible=!1}})}}},Q=m("span",{class:"currency"},"₹",-1),Y={key:2},Z=["onClick"];function $(l,e,v,o,f,r){const F=i("Head"),g=i("a-button"),I=i("a-page-header"),E=i("a-affix"),p=i("a-select-option"),k=i("a-select"),d=i("a-form-item"),w=i("a-input-number"),S=i("a-col"),A=i("a-row"),B=i("DownOutlined"),c=i("a-menu-item"),N=i("a-menu"),j=i("a-dropdown"),x=i("a-form"),R=i("a-layout-content"),b=i("a-input"),U=i("a-drawer"),H=i("a-radio"),K=i("a-radio-group"),V=i("AuthenticatedLayout");return u(),M(q,null,[a(F,{title:"Employees"}),a(V,null,{default:t(()=>[a(E,{"offset-top":0},{default:t(()=>[a(I,{ghost:!1,title:v.employee.name+" Salary Info",onBack:e[2]||(e[2]=()=>l.$inertia.visit(l.route("employees.index")))},{extra:t(()=>[m("h4",null,[s("Total CTC: "),Q,s(" "+O(this.formState.ctc),1)]),a(g,{key:"1",type:"primary",onClick:e[0]||(e[0]=L(()=>{f.otdrawer_visible=!0},["stop"]))},{default:t(()=>[s("OT settings")]),_:1}),a(g,{key:"1",type:"primary",onClick:e[1]||(e[1]=L(()=>{f.latedrawer_visible=!0},["stop"]))},{default:t(()=>[s("Late Penalty Settings")]),_:1})]),_:1},8,["title"])]),_:1}),a(R,null,{default:t(()=>[a(A,null,{default:t(()=>[a(S,{span:12,offset:5},{default:t(()=>[a(x,D({model:o.formState},o.layout,{name:"nest-messages","validate-messages":r.validateMessages,onFinish:r.submit}),{default:t(()=>[a(d,{label:"Salary Type",name:"salary_type",rules:[{required:!0}]},{default:t(()=>[a(k,{placeholder:"Select Salary Type",value:o.formState.salary_type,"onUpdate:value":e[3]||(e[3]=n=>o.formState.salary_type=n),onChange:e[4]||(e[4]=n=>r.calcCTC())},{default:t(()=>[a(p,{value:"Month"},{default:t(()=>[s("Per Month")]),_:1}),a(p,{value:"Day"},{default:t(()=>[s("Per Day")]),_:1}),a(p,{value:"Hour"},{default:t(()=>[s("Per Hour")]),_:1})]),_:1},8,["value"])]),_:1}),o.formState.salary_type=="Day"?(u(),y(d,{key:0,label:"Salary Amount",name:"salary_amount",rules:[{required:!0}]},{default:t(()=>[a(w,{prefix:"₹","addon-after":"/ Day",style:{width:"100%"},value:o.formState.salary_amount,"onUpdate:value":e[5]||(e[5]=n=>o.formState.salary_amount=n),onKeyup:e[6]||(e[6]=n=>r.calcCTC())},null,8,["value"])]),_:1})):_("",!0),o.formState.salary_type=="Hour"?(u(),y(d,{key:1,label:"Salary Amount",name:"salary_amount",rules:[{required:!0}]},{default:t(()=>[a(w,{prefix:"₹","addon-after":"/ Hour",style:{width:"100%"},value:o.formState.salary_amount,"onUpdate:value":e[7]||(e[7]=n=>o.formState.salary_amount=n),onKeyup:e[8]||(e[8]=n=>r.calcCTC())},null,8,["value"])]),_:1})):_("",!0),o.formState.salary_type=="Month"?(u(),M("div",Y,[a(d,{label:"Basic",name:"salary_amount",rules:[{required:!0}]},{default:t(()=>[a(w,{prefix:"₹",style:{width:"100%"},value:o.formState.salary_amount,"onUpdate:value":e[9]||(e[9]=n=>o.formState.salary_amount=n),onKeyup:e[10]||(e[10]=n=>r.calcCTC())},null,8,["value"])]),_:1}),(u(!0),M(q,null,J(o.formState.allowances,(n,C)=>(u(),y(d,{label:C,name:C},{default:t(()=>[a(A,{type:"flex"},{default:t(()=>[a(S,{flex:"auto"},{default:t(()=>[a(w,{prefix:"₹",style:{width:"100%"},value:o.formState.allowances[C],"onUpdate:value":h=>o.formState.allowances[C]=h,onKeyup:e[11]||(e[11]=h=>r.calcCTC())},null,8,["value","onUpdate:value"])]),_:2},1024),a(S,{flex:"80px",style:{"text-align":"right"}},{default:t(()=>[m("a",{onClick:h=>r.removeAllowance(C)},"Remove",8,Z)]),_:2},1024)]),_:2},1024)]),_:2},1032,["label","name"]))),256)),a(d,{"wrapper-col":{span:12,offset:6}},{default:t(()=>[a(j,{trigger:["click"]},{overlay:t(()=>[a(N,null,{default:t(()=>["HRA"in o.formState.allowances?_("",!0):(u(),y(c,{key:"0"},{default:t(()=>[m("a",{onClick:e[13]||(e[13]=n=>r.addAllowances("HRA"))},"HRA")]),_:1})),"Dearness Allowance"in o.formState.allowances?_("",!0):(u(),y(c,{key:"1"},{default:t(()=>[m("a",{onClick:e[14]||(e[14]=n=>r.addAllowances("Dearness Allowance"))},"Dearness Allowance")]),_:1})),"Travel Allowance"in o.formState.allowances?_("",!0):(u(),y(c,{key:"2"},{default:t(()=>[m("a",{onClick:e[15]||(e[15]=n=>r.addAllowances("Travel Allowance"))},"Travel Allowance")]),_:1})),"Meal Allowance"in o.formState.allowances?_("",!0):(u(),y(c,{key:"3"},{default:t(()=>[m("a",{onClick:e[16]||(e[16]=n=>r.addAllowances("Meal Allowance"))},"Meal Allowance")]),_:1})),"Medical Allowance"in o.formState.allowances?_("",!0):(u(),y(c,{key:"4"},{default:t(()=>[m("a",{onClick:e[17]||(e[17]=n=>r.addAllowances("Medical Allowance"))},"Medical Allowance")]),_:1})),"Special Allowance"in o.formState.allowances?_("",!0):(u(),y(c,{key:"5"},{default:t(()=>[m("a",{onClick:e[18]||(e[18]=n=>r.addAllowances("Special Allowance"))},"Special Allowance")]),_:1}))]),_:1})]),default:t(()=>[m("a",{class:"ant-dropdown-link",onClick:e[12]||(e[12]=L(()=>{},["prevent"]))},[s(" + Add Allowance "),a(B)])]),_:1})]),_:1}),a(d,{label:"Employee PF",name:"pf_detail"},{default:t(()=>[a(A,{type:"flex"},{default:t(()=>[a(S,{flex:"auto"},{default:t(()=>[a(k,{placeholder:"Select Salary Type",onChange:e[19]||(e[19]=n=>r.calcCTC()),value:o.formState.pf_detail,"onUpdate:value":e[20]||(e[20]=n=>o.formState.pf_detail=n),style:{width:"100%"}},{default:t(()=>[a(p,{value:"0"},{default:t(()=>[s("None")]),_:1}),a(p,{value:"1"},{default:t(()=>[s("1800 Limit")]),_:1}),a(p,{value:"2"},{default:t(()=>[s("12%")]),_:1})]),_:1},8,["value"])]),_:1}),a(S,{flex:"80px",style:{"text-align":"right"}},{default:t(()=>[m("span",null,"₹ "+O(this.formState.pf_amount),1)]),_:1})]),_:1})]),_:1}),a(d,{label:"Employee ESI",name:"esi_detail"},{default:t(()=>[a(A,{type:"flex"},{default:t(()=>[a(S,{flex:"auto"},{default:t(()=>[a(k,{placeholder:"Select Salary Type",onChange:e[21]||(e[21]=n=>r.calcCTC()),value:o.formState.esi_detail,"onUpdate:value":e[22]||(e[22]=n=>o.formState.esi_detail=n),style:{width:"100%"}},{default:t(()=>[a(p,{value:"0"},{default:t(()=>[s("None")]),_:1}),a(p,{value:"1"},{default:t(()=>[s("0.75%")]),_:1})]),_:1},8,["value"])]),_:1}),a(S,{flex:"80px",style:{"text-align":"right"}},{default:t(()=>[m("span",null,"₹ "+O(this.formState.esi_amount),1)]),_:1})]),_:1})]),_:1})])):_("",!0),a(d,{"wrapper-col":{span:12,offset:6}},{default:t(()=>[a(g,{type:"primary","html-type":"submit"},{default:t(()=>[s("Save")]),_:1})]),_:1})]),_:1},16,["model","validate-messages","onFinish"])]),_:1})]),_:1})]),_:1}),a(U,{width:600,title:"OT Settings",placement:"right",closable:!0,visible:f.otdrawer_visible,onClose:e[27]||(e[27]=n=>f.otdrawer_visible=!1)},{default:t(()=>[a(x,D({model:o.OtformState},o.layout,{name:"nest-messages","validate-messages":r.validateMessages,onFinish:r.OTsubmit}),{default:t(()=>[a(d,{label:"Week off Pay",labelCol:{span:8},name:"weekoff_pay",rules:[{required:!0}]},{default:t(()=>[a(b,{value:o.OtformState.weekoff_pay,"onUpdate:value":e[23]||(e[23]=n=>o.OtformState.weekoff_pay=n),prefix:"₹"},null,8,["value"])]),_:1}),a(d,{label:"Public Holiday Pay",labelCol:{span:8},name:"publicholiday_pay",rules:[{required:!0}]},{default:t(()=>[a(b,{value:o.OtformState.publicholiday_pay,"onUpdate:value":e[24]||(e[24]=n=>o.OtformState.publicholiday_pay=n),prefix:"₹"},null,8,["value"])]),_:1}),a(d,{label:"Extra Hours Pay",labelCol:{span:8},name:"extra_hours_pay",rules:[{required:!0}]},{default:t(()=>[a(b,{value:o.OtformState.extra_hours_pay,"onUpdate:value":e[25]||(e[25]=n=>o.OtformState.extra_hours_pay=n),prefix:"₹"},null,8,["value"])]),_:1}),a(d,{label:"Grace Period",name:"grace_period",rules:[{required:!0}]},{default:t(()=>[a(b,{value:o.OtformState.grace_period,"onUpdate:value":e[26]||(e[26]=n=>o.OtformState.grace_period=n),"addon-after":"Minutes"},null,8,["value"])]),_:1}),a(d,{"wrapper-col":{span:12,offset:6}},{default:t(()=>[a(g,{type:"primary","html-type":"submit"},{default:t(()=>[s("Save")]),_:1})]),_:1}),s("s ")]),_:1},16,["model","validate-messages","onFinish"])]),_:1},8,["visible"]),a(U,{width:600,title:"Late Penalty Settings",placement:"right",closable:!0,visible:f.latedrawer_visible,onClose:e[32]||(e[32]=n=>f.latedrawer_visible=!1)},{default:t(()=>[a(x,D({model:o.LateformState},o.layout,{name:"nest-messages","validate-messages":r.validateMessages,onFinish:r.lateSubmit}),{default:t(()=>[a(d,{label:"Allowed Days",labelCol:{span:8},name:"allowed_days",rules:[{required:!0}]},{default:t(()=>[a(w,{value:o.LateformState.allowed_days,"onUpdate:value":e[28]||(e[28]=n=>o.LateformState.allowed_days=n)},null,8,["value"])]),_:1}),a(d,{label:"Grace Period",name:"grace_period",rules:[{required:!0}]},{default:t(()=>[a(b,{value:o.LateformState.grace_period,"onUpdate:value":e[29]||(e[29]=n=>o.LateformState.grace_period=n),"addon-after":"Minutes"},null,8,["value"])]),_:1}),a(d,{label:"Deduction Type",name:"deduction_type",rules:[{required:!0}]},{default:t(()=>[a(K,{value:o.LateformState.deduction_type,"onUpdate:value":e[30]||(e[30]=n=>o.LateformState.deduction_type=n),name:"deduction_type"},{default:t(()=>[a(H,{value:"Day"},{default:t(()=>[s("Day")]),_:1}),a(H,{value:"Hour"},{default:t(()=>[s("Hour")]),_:1})]),_:1},8,["value"])]),_:1}),a(d,{label:"Deductin Rate",labelCol:{span:8},name:"deduction_rate",rules:[{required:!0}]},{default:t(()=>[a(w,{value:o.LateformState.deduction_rate,"onUpdate:value":e[31]||(e[31]=n=>o.LateformState.deduction_rate=n),prefix:"₹"},null,8,["value"])]),_:1}),a(d,{"wrapper-col":{span:12,offset:6}},{default:t(()=>[a(g,{type:"primary","html-type":"submit"},{default:t(()=>[s("Save")]),_:1})]),_:1}),s("s ")]),_:1},16,["model","validate-messages","onFinish"])]),_:1},8,["visible"])]),_:1})],64)}const le=X(z,[["render",$]]);export{le as default};
