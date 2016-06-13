for i in AAPL AMZN CAJ FB GOOG MSFT SNE TWTR WMT YHOO ; do
    for ((j = 0; j < 243; j++)); do
	./svm-train -s 3 stock/SVMHistroy_${i}_train${j}.txt stock/SVMHistroy_${i}${j}.model    
	./svm-predict stock/SVMHistroy_${i}_test${j}.txt stock/SVMHistroy_${i}${j}.model stock/SVMHistroy_${i}_result${j}.txt
    done
done
