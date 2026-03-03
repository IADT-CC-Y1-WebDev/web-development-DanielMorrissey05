import Animal from "./Animal.js";

class Feline extends Animal {

    constructor(_name, _age){
        super(_name, _age);
        
    }

    makeNoise(){
        console.log("Roaming: roaaaaarrrr!");
    }

}

export default Feline;