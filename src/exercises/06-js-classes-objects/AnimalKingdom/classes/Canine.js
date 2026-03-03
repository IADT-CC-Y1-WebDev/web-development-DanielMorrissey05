import Animal from "./Animal.js";

class Canine extends Animal {

    constructor(_name, _age){
        super(_name, _age);
        
    }

    makeNoise(){
        console.log("Howling: roaaaaarrrr!");
    }

}

export default Canine;