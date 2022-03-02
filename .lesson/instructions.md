# Instructions  

There is a competition for startups where each company show their ideas for some judges, the judges controls who wins and goes to the next step (the companies who were not selected will be terminated), when all the steps are done only one company will win the competition, and you will be the judge :).

## Requirements
- Write a variable that holds the name of the competing companies, the number should not be less than 20.
  - Use [arrays](https://www.php.net/manual/en/language.types.array.php)
- Write a function that calculates the companies that will qualifies to the next step according to the following rules:
  - The function takes 2 arguments, the name of the countries and the success Rate
    > function successfulCompanies($companyNames, $successRate)
  - The successfulCompanies should use the [rand](https://www.w3schools.com/php/func_math_rand.asp) function to give each company a random score between 0 and 100 as a score.
  - If this random score less than the pass rate it means that this company passed this step.
  - If all the companies failed in the same step then we select the company with the least score and this company will be the winner.
- The pass rate starts with `50%` and in each step it goes down by half
  - `50%` => `25%` => `12.5%` ...
- The program ends when only 1 company is left from the elimination rounds, and then the program should print the a proper message for this company as a congratulations.

# Arabic Instructions  

![alt text](assets/instructions.png)

> [rand](https://www.w3schools.com/php/func_math_rand.asp)