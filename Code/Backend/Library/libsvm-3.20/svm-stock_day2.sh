for i in AAPL AMZN CAJ FB GOOG MSFT SNE TWTR WMT YHOO ; do
    ./svm-predict stock/SVMHistroy_${i}_test243.txt stock/SVMHistroy_${i}242.model stock/SVMHistroy_${i}_result243.txt   
done