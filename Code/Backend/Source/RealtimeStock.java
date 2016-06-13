package stockforecaster;

/*
 Written by: Dongyang Yao, Zihong Zheng, Weiran Fang
 Assisted by: Ke Dong
 Debugged by: Xi Zhang
 */
import java.sql.*;
import java.util.*;
import yahoofinance.Stock;
import yahoofinance.YahooFinance;
import java.text.SimpleDateFormat;

public class RealtimeStock extends TimerTask {

    private Stock[] stock;
    private double[] price;
    private Calendar cale;
    private long[] volume;

    public RealtimeStock() {

        stock = new Stock[StockForecaster.SYMBOLS.length];
        price = new double[StockForecaster.SYMBOLS.length];
        volume = new long[StockForecaster.SYMBOLS.length];

        for (int i = 0; i < StockForecaster.SYMBOLS.length; ++i) {
            this.stock[i] = YahooFinance.get(StockForecaster.SYMBOLS[i]);
        }
    }

    @Override
    public void run() {

        cale = Calendar.getInstance();
        java.util.Date taskTime = cale.getTime();
        SimpleDateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd_HH-mm-ss");
        String nowTime = dateFormat.format(taskTime);

        try {

            Connection connection;

            connection = DriverManager.getConnection(DatabaseManager.URL + DatabaseManager.DATABASE_NAME, DatabaseManager.USER_NAME, DatabaseManager.PASSWORD);

            Statement statement = connection.createStatement();

            for (int i = 0; i < StockForecaster.SYMBOLS.length; ++i) {

                price[i] = stock[i].getQuote().getPrice().doubleValue();
                volume[i] = stock[i].getQuote().getVolume();

                //System.out.println(price[i] + " " + volume[i]);
                statement.executeUpdate("INSERT INTO StockRealtime VALUES ('" + StockForecaster.SYMBOLS[i] + "', '" + nowTime + "', " + price[i] + ", " + volume[i] + ")");
            }

            connection.close();

        } catch (Exception e) {
            System.out.println("database operation error.");
        }

    }
}
