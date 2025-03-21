function fibonacci(num) {
    let num1 = 0;
    let num2 = 1;
    let sum;
    let fibArr = [num1, num2];
    for (let i = 2; i < num; i++) {
      sum = num1 + num2;
      num1 = num2;
      num2 = sum;
      fibArr.push(sum);
    }
    return fibArr;
  }
  
  console.log(fibonacci(10));