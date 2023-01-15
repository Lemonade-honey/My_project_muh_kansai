var language = {
    eng:{
        data : "test",
    },
    idn:{
        data : "hayoo"
    }
}

console.log(Object.keys(language.eng).length)

if(window.location.hash){
    
}
if(window.location.hash === "idn"){
    console.log("masuk indo")
}