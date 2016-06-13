package stockforecaster;
/*
 Written by: Dongyang Yao, Zihong Zheng, Weiran Fang
 Assisted by: Ke Dong
 Debugged by: Xi Zhang
 */

import java.io.*;
import java.sql.*;
import java.util.*;

public class MovingAverage {

    private List<Double> historicalData;
    private List<String> historicalDate;
    private final int SMAPeriod15 = 15;
    private final int EMAPeriod15 = 15;
    private final int EMAPeriod3 = 3;

    public void CalculateSMA15() {

        historicalData = new ArrayList<>();
        historicalDate = new ArrayList<>();

        try {

            Connection connection;

            connection = DriverManager.getConnection(DatabaseManager.URL + DatabaseManager.DATABASE_NAME, DatabaseManager.USER_NAME, DatabaseManager.PASSWORD);

            Statement statement = connection.createStatement();

            for (int j = 0; j < StockForecaster.SYMBOLS.length; j++) {

                loadData(j);

                for (int i = SMAPeriod15 - 1; i < historicalData.size(); i++) {

                    double sum = 0.0;
                    for (int m = 0; m < SMAPeriod15; m++) {
                        sum += historicalData.get(i - m);
                    }

                    double sma = Math.round((sum / SMAPeriod15) * 100.0) / 100.0;
                    statement.executeUpdate("INSERT INTO SMA15 VALUES ('" + StockForecaster.SYMBOLS[j] + "', '" + historicalDate.get(i) + "', " + sma + ")");

                }

            }

            connection.close();

        } catch (Exception e) {
            e.printStackTrace();
            System.out.println("database operation error 2.");
        }
    }

    public void CalculateEMA15() {

        historicalData = new ArrayList<>();
        historicalDate = new ArrayList<>();

        try {

            Connection connection;

            connection = DriverManager.getConnection(DatabaseManager.URL + DatabaseManager.DATABASE_NAME, DatabaseManager.USER_NAME, DatabaseManager.PASSWORD);

            Statement statement = connection.createStatement();

            for (int j = 0; j < StockForecaster.SYMBOLS.length; j++) {

                loadData(j);

                double sum = 0.0;
                for (int m = 0; m < EMAPeriod15; m++) {
                    sum += historicalData.get(EMAPeriod15 - 1 - m);
                }
                double yesterdayEMA = sum / EMAPeriod15;

                double ema = 0.0;

                for (int i = EMAPeriod15; i < historicalData.size(); i++) {

                    ema = CalculateEMA(historicalData.get(i), EMAPeriod15, yesterdayEMA);
                    ema = Math.round(ema * 100.0) / 100.0;
                    statement.executeUpdate("INSERT INTO EMA15 VALUES ('" + StockForecaster.SYMBOLS[j] + "', '" + historicalDate.get(i) + "', " + ema + ")");
                    yesterdayEMA = ema;

                }

            }

            connection.close();

        } catch (Exception e) {
            e.printStackTrace();
            System.out.println("database operation error 2.");
        }
    }

    public void CalculateEMA3() {

        historicalData = new ArrayList<>();
        historicalDate = new ArrayList<>();

        try {

            Connection connection;

            connection = DriverManager.getConnection(DatabaseManager.URL + DatabaseManager.DATABASE_NAME, DatabaseManager.USER_NAME, DatabaseManager.PASSWORD);

            Statement statement = connection.createStatement();

            for (int j = 0; j < StockForecaster.SYMBOLS.length; j++) {

                loadData(j);

                double sum = 0.0;
                for (int m = 0; m < EMAPeriod3; m++) {
                    sum += historicalData.get(EMAPeriod3 - 1 - m);
                }
                double yesterdayEMA = sum / EMAPeriod3;

                double ema = 0.0;

                for (int i = EMAPeriod3; i < historicalData.size(); i++) {

                    ema = CalculateEMA(historicalData.get(i), EMAPeriod3, yesterdayEMA);
                    ema = Math.round(ema * 100.0) / 100.0;
                    statement.executeUpdate("INSERT INTO EMA3 VALUES ('" + StockForecaster.SYMBOLS[j] + "', '" + historicalDate.get(i) + "', " + ema + ")");
                    yesterdayEMA = ema;

                }

            }

            connection.close();

        } catch (Exception e) {
            e.printStackTrace();
            System.out.println("database operation error 2.");
        }
    }

    public double CalculateEMA(double todaysPrice, double numberOfDays, double EMAYesterday) {
        double k = 2 / (numberOfDays + 1);
        return todaysPrice * k + EMAYesterday * (1 - k);
    }

    private void loadData(int CompanyIndex) {

        historicalData.clear();
        historicalDate.clear();

        try {

            Connection connection;

            connection = DriverManager.getConnection(DatabaseManager.URL + DatabaseManager.DATABASE_NAME, DatabaseManager.USER_NAME, DatabaseManager.PASSWORD);

            Statement statement = connection.createStatement();

            ResultSet res = statement.executeQuery("SELECT * FROM StockHistorical WHERE Symbol = '" + StockForecaster.SYMBOLS[CompanyIndex] + "'");

            while (res.next()) {
                historicalData.add(res.getDouble("ClosePrice"));
                historicalDate.add(res.getString("Date"));
            }

            connection.close();

        } catch (Exception e) {
            System.out.println("database operation error 1.");
        }

    }
}
