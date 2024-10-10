import currency from 'currency.js'

export class MoneyHandler {
  constructor (money) {
    this.money = money
  }

  format() {
    return currency(this.money.price, { fromCents: false, precision: 2, symbol: this.money.currency + ' ' }).format()
  }
}