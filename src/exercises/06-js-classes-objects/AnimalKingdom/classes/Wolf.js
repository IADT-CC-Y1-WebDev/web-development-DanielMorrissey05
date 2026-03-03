import Animal from "./Animal.js";

class Wolf extends Animal {

    constructor(_name, _age){
        super(_name, _age);
        
    }

    makeNoise(){
        console.log("Howling: awoooooooh!");
    }

}

export default Wolf;