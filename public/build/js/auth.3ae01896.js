(self.webpackChunk=self.webpackChunk||[]).push([[828],{550:()=>{!function(e,s){"use strict";const t=e("#resend");t.length>0&&e.ajax({url:"/en/auth/should_link_be_visible",type:"GET",data:{csrf_token:t.data("token")},success:function(e){!0===e.display&&t.show()}});t.click((()=>{e.ajax({url:t.data("path"),type:"POST",data:{csrf_token:t.data("token")},success:function(e){t.hide(),s.alert(e.message)}})}))}($,bootbox)},175:(e,s,t)=>{"use strict";t(550)}},e=>{var s;s=175,e(e.s=s)}]);