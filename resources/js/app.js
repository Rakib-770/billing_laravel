require('./bootstrap');

const Colosia = ["amber", "triangle"];

const mapped = Colosia.map(client => client + "hello");

console.log(mapped);
