package stockforecaster;
/*
 Written by: Dongyang Yao, Zihong Zheng, Weiran Fang
 Assisted by: Ke Dong
 Debugged by: Xi Zhang
 */

import java.util.*;

public class StockForecaster {

    public static final int REALTIME_STOCK_INTERVAL = 5;
    public static final int HISTORICAL_STOCK_INTERVAL = 24 * 60 * 60;
    public static final String[] SYMBOLS = {"GOOG", "YHOO", "AAPL", "FB", "MSFT", "AMZN", "SNE", "WMT", "CAJ", "TWTR"};
    private HistoricalStock historicalStock;
    private RealtimeStock realtimeStock;
    private BayesianPredictor bayesianPredictor;
    private STSPredictor stsPredictor;
    private SVM svm;
    private MovingAverage ma;
    private MACDPredictor macd;
    private AI ai;
    private ANN ann;

    private Timer realtimeStockTimer;
    private Timer historicalStockTimer;

    public StockForecaster() {

        realtimeStockTimer = new Timer();
        realtimeStock = new RealtimeStock();
        realtimeStockTimer.schedule(realtimeStock, 0, REALTIME_STOCK_INTERVAL * 1000);

        historicalStockTimer = new Timer();
        historicalStock = new HistoricalStock(1);
        historicalStockTimer.schedule(historicalStock, 0, HISTORICAL_STOCK_INTERVAL * 1000);

        try {
            Thread.sleep(10000);
        } catch (InterruptedException ie) {

        }

        bayesianPredictor = new BayesianPredictor();
        bayesianPredictor.ShortTermPredictAll();
        bayesianPredictor.LongTermPredictAll();

        stsPredictor = new STSPredictor();
        stsPredictor.ShortTermPredictAll();
        stsPredictor.LongTermPredictAll();

        svm = new SVM();
        svm.trainWithHistory();

        // After testing with command line 
        //svm.testDay2();
        //svm.storeResult();
        ma = new MovingAverage();
        ma.CalculateSMA15();
        ma.CalculateEMA15();
        ma.CalculateEMA3();

        macd = new MACDPredictor();
        macd.PredictAll();

        ann = new ANN();
        ann.predictHistory();

        ai = new AI();
        ai.runAI();

    }

    public static void main(String[] args) {
        StockForecaster stockForecaster = new StockForecaster();
    }

}
