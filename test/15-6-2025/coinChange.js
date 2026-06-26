function coinChange(coins, amount) {
  const dp = Array(amount + 1).fill(Infinity);

  dp[0] = 0;

  for (let coin of coins) {
    for (let i = coin; i <= amount; i++) {//1<=3,2<=3
      dp[i] = Math.min(dp[i], dp[i - coin] + 1);//(&,1),(&,1),(&,2)
    }
  }

  return dp[amount] === Infinity ? -1 : dp[amount];
}
coins = [1,2];
amount = 3; //
console.log(coinChange(coins, amount));
