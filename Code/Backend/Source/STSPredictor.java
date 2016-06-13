package stockforecaster;
/*
 Written by: Dongyang Yao, Zihong Zheng, Weiran Fang
 Assisted by: Ke Dong
 Debugged by: Xi Zhang
 */

import java.sql.*;
import java.util.*;

public class STSPredictor {

    private final int dataLength = 20;
    private final int daylength = 5;

    private STS sts;

    private List<Double> historicalData;
    private List<String> historicalDate;

    public void LongTermPredictAll() {
        historicalData = new ArrayList();
        historicalDate = new ArrayList();

        sts = new STS();

        try {

            Connection connection;

            connection = DriverManager.getConnection(DatabaseManager.URL + DatabaseManager.DATABASE_NAME, DatabaseManager.USER_NAME, DatabaseManager.PASSWORD);

            Statement statement = connection.createStatement();

            for (int j = 0; j < StockForecaster.SYMBOLS.length; j++) {

                // Load history data of each company
                loadData(j);

                double differencePast = 0;
                double predictionPast = 0;
                List<Double> LongTermTemp = new ArrayList<Double>();

                for (int i = historicalData.size() - 1; i >= 10; i = i - 10) {
                    double sum = 0;
                    for (int k = 0; k < 10; k++) {
                        sum = sum + historicalData.get(i - k);
                    }
                    double average = sum / 10;
                    LongTermTemp.add(average);
                }
                List<Double> LongTermList = new ArrayList<Double>();
                for (int i = 0; i < LongTermTemp.size(); i++) {
                    LongTermList.add(LongTermTemp.get(LongTermTemp.size() - i - 1));
                }
                List<Double> calculate = LongTermList.subList(LongTermList.size() - dataLength - 1, LongTermList.size());
                List<Double> result = sts.getShort(calculate);
                for (int i = 1; i < 3; i++) {
                    LongTermList.add(result.get(i + 1));
                }
                for (int i = 0; i < LongTermList.size(); i++) {
                    double displaynum = Math.round(LongTermList.get(i) * 100.0) / 100.0;
                    Statement stat = connection.createStatement();
                    stat.executeUpdate("INSERT INTO Lpredictionsts VALUES ('" + StockForecaster.SYMBOLS[j] + "', " + (i - LongTermList.size() + 3) + "," + displaynum + ")");

                }

            }

            connection.close();
        } catch (Exception e) {
            e.printStackTrace();
            System.out.println("database operation error 2.");
        }
    }

    public void ShortTermPredictAll() {

        historicalData = new ArrayList();
        historicalDate = new ArrayList();

        sts = new STS();

        try {

            Connection connection;

            connection = DriverManager.getConnection(DatabaseManager.URL + DatabaseManager.DATABASE_NAME, DatabaseManager.USER_NAME, DatabaseManager.PASSWORD);

            Statement statement = connection.createStatement();

            for (int j = 0; j < StockForecaster.SYMBOLS.length; j++) {

                loadData(j);

                for (int i = 0; i < (historicalData.size() - dataLength); i++) {

                    List<Double> pricecls = historicalData.subList(i, dataLength + i + 1);
                    List<Double> actionlist = pricecls.subList(0, dataLength);

                    String action = sts.getAction(actionlist);
                    //double prediction = sts.getPrediction(pricecls);
                    List<Double> predictions = sts.getShort(pricecls);
                    //prediction = Math.round(prediction * 100.0) / 100.0;

                    double RelativeDifference = sts.getDiff(pricecls);

                    statement.executeUpdate("INSERT INTO Spredictionsts VALUES ('" + StockForecaster.SYMBOLS[j] + "', '" + historicalDate.get(i + dataLength) + "', " + predictions.get(0) + ", " + predictions.get(1) + ", " + predictions.get(2) + ", " + RelativeDifference + ",'" + action + "')");
                    //statement.execute("INSERT INTO xxx VALUES ('" + StockForecaster.SYMBOLS[j] + "', '")
                }

            }

            connection.close();

        } catch (Exception e) {
            e.printStackTrace();
            System.out.println("database operation error 2.");
        }
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
