package stockforecaster;
/*
 Written by: Dongyang Yao, Zihong Zheng, Weiran Fang
 Assisted by: Ke Dong
 Debugged by: Xi Zhang
 */

import yahoofinance.Stock;
import yahoofinance.YahooFinance;
import yahoofinance.histquotes.HistoricalQuote;
import yahoofinance.histquotes.Interval;
import java.util.*;
import java.sql.*;
import java.text.SimpleDateFormat;

public class HistoricalStock extends TimerTask {

    private int numYear;
    private List<HistoricalQuote>[] listHistory;

    public HistoricalStock(int y) {
        numYear = y;
        listHistory = (List<HistoricalQuote>[]) new List[StockForecaster.SYMBOLS.length];

        Calendar from = Calendar.getInstance();
        from.add(Calendar.YEAR, -numYear);

        for (int i = 0; i < StockForecaster.SYMBOLS.length; i++) {
            Stock stock = YahooFinance.get(StockForecaster.SYMBOLS[i], from, Interval.DAILY);
            listHistory[i] = stock.getHistory();
        }

    }

    @Override
    public void run() {
        this.collectData();
    }

    public void collectData() {

        try {

            Connection connection;

            connection = DriverManager.getConnection(DatabaseManager.URL + DatabaseManager.DATABASE_NAME, DatabaseManager.USER_NAME, DatabaseManager.PASSWORD);

            Statement statement = connection.createStatement();

            for (int i = 0; i < StockForecaster.SYMBOLS.length; i++) {

                String symbol = StockForecaster.SYMBOLS[i];
                String date;
                double open, high, low, close;
                long volume;

                double closePast = 0;
                boolean isFirst = true;
                double difference = 0;

                List<HistoricalQuote> historicalQuotes = listHistory[i];

                Collections.reverse(historicalQuotes);

                for (HistoricalQuote dayData : historicalQuotes) {

                    Calendar cd = dayData.getDate();
                    SimpleDateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd");
                    date = dateFormat.format(cd.getTime());
                    open = dayData.getOpen().doubleValue();
                    high = dayData.getHigh().doubleValue();
                    low = dayData.getLow().doubleValue();
                    close = dayData.getClose().doubleValue();
                    volume = dayData.getVolume();

                    ResultSet res = statement.executeQuery("SELECT * FROM StockHistorical WHERE Symbol = '" + symbol + "' AND Date = '" + date + "'");

                    if (!res.next()) {

                        // A bug here
                        // The first new difference should not be 0 if db is not empty
                        if (isFirst) {
                            statement.executeUpdate("INSERT INTO StockHistorical VALUES ('" + symbol + "', '" + date + "', " + open + ", " + close + ", " + low + ", " + high + ", " + volume + ", " + difference + ")");
                            isFirst = false;
                            //System.out.println(symbol + " " + date + " " + close + " " + closePast + " " + difference);
                            closePast = close;
                        } else {
                            difference = Math.round((close - closePast) * 100.0) / 100.0;
                            statement.executeUpdate("INSERT INTO StockHistorical VALUES ('" + symbol + "', '" + date + "', " + open + ", " + close + ", " + low + ", " + high + ", " + volume + ", " + difference + ")");
                            //System.out.println(symbol + " " + date + " " + close + " " + closePast + " " + difference);
                            closePast = close;

                        }

                    }

                }

            }

            connection.close();

        } catch (Exception e) {
            System.out.println("database operation error.");
        }

    }

}
