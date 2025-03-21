const calculator = (operator, ...numbers) => {
    if (numbers.length < 2) return "Masukkan minimal dua angka";
    
    switch (operator) {
        case '+':
            return numbers.reduce((acc, num) => acc + num);
        case '-':
            return numbers.reduce((acc, num) => acc - num);
        case '*':
            return numbers.reduce((acc, num) => acc * num);
        case '/':
            return numbers.reduce((acc, num) => (num !== 0 ? acc / num : "Error: Pembagian dengan nol"));
        case '%':
            return numbers.reduce((acc, num) => acc % num);
        default:
            return "Operator tidak valid";
    }
};

console.log(calculator('+', 10, 5, 3));
console.log(calculator('-', 20, 10));
console.log(calculator('*', 4, 5));
console.log(calculator('/', 100, 5, 2));
console.log(calculator('%', 10, 3));