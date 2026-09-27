const express=require('express');
const path=require('path');
const app=express();
app.use(express.json({limit:'256kb'}));
app.use(express.static(path.join(__dirname,'public')));

// SignBridge local-only interpretation endpoint.
// Core recognition is performed by the browser/model; no external LLM is called here.
app.post('/api/ai/interpret',(req,res)=>{
  const allowed=new Set(['Hello','Thank you','Please','Help','Yes','No']);
  const gesture=String(req.body?.gesture||'').trim();
  if(!allowed.has(gesture)) return res.status(422).json({success:false,message:'Unsupported SignBridge vocabulary item.'});
  res.json({success:true,text:gesture,provider:'SignBridge local recognition'});
});

app.get('/health',(req,res)=>res.json({success:true,service:'SignBridge local server'}));
const port=process.env.PORT||3000;
app.listen(port,()=>console.log(`SignBridge running on http://localhost:${port}`));
