package stockforecaster;
/*
 Written by: Dongyang Yao, Zihong Zheng, Weiran Fang
 Assisted by: Ke Dong
 Debugged by: Xi Zhang
 */

import java.sql.*;
import java.util.*;
import java.io.*;

public class SVM {

    private List<Double> historicalData;
    private List<String> historicalDate;

    private List<Double> EMA15Data;
    private List<String> EMA15Date;

    private List<Double> EMA3Data;
    private List<String> EMA3Date;

    public static final int featureLength = 4;
    public static final int numberOfExample = 5;

    public void testDay2() {
        historicalData = new ArrayList<>();
        historicalDate = new ArrayList<>();

        try {

            Connection connection;

            connection = DriverManager.getConnection(DatabaseManager.URL + DatabaseManager.DATABASE_NAME, DatabaseManager.USER_NAME, DatabaseManager.PASSWORD);

            Statement statement = connection.createStatement();

            for (int j = 0; j < StockForecaster.SYMBOLS.length; j++) {

                loadData(j);

                int k = historicalData.size() - numberOfExample - featureLength + 1;

                PrintWriter f1 = new PrintWriter(new FileWriter("SVM/libsvm-3.20/stock/" + "SVMHistroy_" + StockForecaster.SYMBOLS[j] + "_test" + k + ".txt"));

                String feature = "";

                for (int m = 1; m < featureLength; m++) {
                    feature += " " + m + ":" + historicalData.get(m - 1 + k + numberOfExample);
                }

                int i = historicalData.size() - numberOfExample - featureLength;

                try {

                    BufferedReader bufferedReader = new BufferedReader(new FileReader("SVM/libsvm-3.20/stock/" + "SVMHistroy_" + StockForecaster.SYMBOLS[j] + "_result" + i + ".txt"));
                    String line;

                    while ((line = bufferedReader.readLine()) != null) {
                        feature += " " + featureLength + ":" + Double.parseDouble(line);
                    }

                } catch (FileNotFoundException e) {
                    System.out.println("file error!");
                } catch (IOException e) {
                    System.out.println("io error!");
                }

                //System.out.println(historicalDate.get(k + numberOfExample + featureLength));
                f1.println(0 + feature);

                f1.close();

            }

            connection.close();

        } catch (Exception e) {
            e.printStackTrace();
            System.out.println("database operation error 2.");
        }
    }

    public void trainWithHistory() {

        historicalData = new ArrayList<>();
        historicalDate = new ArrayList<>();

        try {

            Connection connection;

            connection = DriverManager.getConnection(DatabaseManager.URL + DatabaseManager.DATABASE_NAME, DatabaseManager.USER_NAME, DatabaseManager.PASSWORD);

            Statement statement = connection.createStatement();

            for (int j = 0; j < StockForecaster.SYMBOLS.length; j++) {

                loadData(j);

                for (int k = 0; k < historicalData.size() - numberOfExample - featureLength; k++) {

                    PrintWriter f0 = new PrintWriter(new FileWriter("SVM/libsvm-3.20/stock/" + "SVMHistroy_" + StockForecaster.SYMBOLS[j] + "_train" + k + ".txt"));
                    PrintWriter f1 = new PrintWriter(new FileWriter("SVM/libsvm-3.20/stock/" + "SVMHistroy_" + StockForecaster.SYMBOLS[j] + "_test" + k + ".txt"));

                    for (int i = k; i < k + numberOfExample; i++) {

                        String feature = "";

                        for (int m = 1; m <= featureLength; m++) {
                            feature += " " + m + ":" + historicalData.get(m - 1 + i);
                        }

                        f0.println(historicalData.get(i + featureLength) + feature);
                    }

                    String feature = "";

                    for (int m = 1; m <= featureLength; m++) {
                        feature += " " + m + ":" + historicalData.get(m - 1 + k + numberOfExample);
                    }

                    //System.out.println(historicalDate.get(k + numberOfExample + featureLength));
                    f1.println(historicalData.get(k + numberOfExample + featureLength) + feature);

                    f0.close();
                    f1.close();
                }

                int k = historicalData.size() - numberOfExample - featureLength;

                PrintWriter f0 = new PrintWriter(new FileWriter("SVM/libsvm-3.20/stock/" + "SVMHistroy_" + StockForecaster.SYMBOLS[j] + "_train" + k + ".txt"));
                PrintWriter f1 = new PrintWriter(new FileWriter("SVM/libsvm-3.20/stock/" + "SVMHistroy_" + StockForecaster.SYMBOLS[j] + "_test" + k + ".txt"));

                for (int i = historicalData.size() - numberOfExample - featureLength; i < k + numberOfExample; i++) {

                    String feature = "";

                    for (int m = 1; m <= featureLength; m++) {
                        feature += " " + m + ":" + historicalData.get(m - 1 + i);
                    }

                    f0.println(historicalData.get(i + featureLength) + feature);
                }

                String feature = "";

                for (int m = 1; m <= featureLength; m++) {
                    feature += " " + m + ":" + historicalData.get(m - 1 + k + numberOfExample);
                }

                //System.out.println(historicalDate.get(k + numberOfExample + featureLength));
                f1.println(0 + feature);

                f0.close();
                f1.close();

            }

            connection.close();

        } catch (Exception e) {
            e.printStackTrace();
            System.out.println("database operation error 2.");
        }

    }

    public void storeResult() {

        historicalData = new ArrayList<>();
        historicalDate = new ArrayList<>();

        try {

            Connection connection;

            connection = DriverManager.getConnection(DatabaseManager.URL + DatabaseManager.DATABASE_NAME, DatabaseManager.USER_NAME, DatabaseManager.PASSWORD);

            Statement statement = connection.createStatement();

            for (int j = 0; j < StockForecaster.SYMBOLS.length; j++) {

                loadData(j);

                int m = numberOfExample + featureLength;

                for (int i = 0; i < historicalData.size() - numberOfExample - featureLength; i++) {
                    try {

                        BufferedReader bufferedReader = new BufferedReader(new FileReader("SVM/libsvm-3.20/stock/" + "SVMHistroy_" + StockForecaster.SYMBOLS[j] + "_result" + i + ".txt"));
                        String line;

                        while ((line = bufferedReader.readLine()) != null) {
                            double difference = (Double.parseDouble(line) - historicalData.get(m)) / historicalData.get(m) * 100;
                            String action;
                            if (Double.parseDouble(line) - historicalData.get(m - 1) > 0) {
                                action = "BUY";
                            } else if ((Double.parseDouble(line) - historicalData.get(m - 1) < 0)) {
                                action = "SELL";
                            } else {
                                action = "HOLD";
                            }
                            statement.executeUpdate("INSERT INTO PredictionSVM VALUES ('" + StockForecaster.SYMBOLS[j] + "', '" + historicalDate.get(m) + "', " + Math.round(Double.parseDouble(line) * 100.0) / 100.0 + "," + Math.abs(Math.round(difference * 100.0) / 100.0) + ", '" + action + "')");
                            m++;
                        }

                    } catch (FileNotFoundException e) {
                        System.out.println("file error!");
                    } catch (IOException e) {
                        System.out.println("io error!");
                    }
                }

                int i = historicalData.size() - numberOfExample - featureLength;

                try {

                    BufferedReader bufferedReader = new BufferedReader(new FileReader("SVM/libsvm-3.20/stock/" + "SVMHistroy_" + StockForecaster.SYMBOLS[j] + "_result" + i + ".txt"));
                    String line;

                    while ((line = bufferedReader.readLine()) != null) {

                        String action;
                        if (Double.parseDouble(line) - historicalData.get(m - 1) > 0) {
                            action = "BUY";
                        } else if ((Double.parseDouble(line) - historicalData.get(m - 1) < 0)) {
                            action = "SELL";
                        } else {
                            action = "HOLD";
                        }

                        statement.executeUpdate("INSERT INTO PredictionSVM VALUES ('" + StockForecaster.SYMBOLS[j] + "', 'predict day 1', " + Math.round(Double.parseDouble(line) * 100.0) / 100.0 + ", 0, '" + action + "')");

                    }

                } catch (FileNotFoundException e) {
                    System.out.println("file error!");
                } catch (IOException e) {
                    System.out.println("io error!");
                }

                i++;

                try {

                    BufferedReader bufferedReader = new BufferedReader(new FileReader("SVM/libsvm-3.20/stock/" + "SVMHistroy_" + StockForecaster.SYMBOLS[j] + "_result" + i + ".txt"));
                    String line;

                    while ((line = bufferedReader.readLine()) != null) {

                        statement.executeUpdate("INSERT INTO PredictionSVM VALUES ('" + StockForecaster.SYMBOLS[j] + "', 'predict day 2', " + Math.round(Double.parseDouble(line) * 100.0) / 100.0 + ", 0, 'NULL')");

                    }

                } catch (FileNotFoundException e) {
                    System.out.println("file error!");
                } catch (IOException e) {
                    System.out.println("io error!");
                }

            }

            connection.close();

        } catch (Exception e) {
            e.printStackTrace();
            System.out.println("database operation error 2.");
        }

    }

    /*
     public void trainWithRDP() {

     historicalData = new ArrayList<>();
     historicalDate = new ArrayList<>();

     try {

     Connection connection;

     connection = DriverManager.getConnection(DatabaseManager.URL + DatabaseManager.DATABASE_NAME, DatabaseManager.USER_NAME, DatabaseManager.PASSWORD);

     Statement statement = connection.createStatement();

     for (int j = 0; j < StockForecaster.SYMBOLS.length; j++) {

     loadData(j);

     PrintWriter f = new PrintWriter(new FileWriter("SVM/libsvm-3.20/stock/" + "SVMHistroy_" + StockForecaster.SYMBOLS[j] + "_train.txt"));

     for (int k = 0; k <) {
     for (int i = featureLength; i < (historicalData.size() / 2); i++) {

     String feature = "";

     for (int m = 1; m <= featureLength; m++) {
     feature += " " + m + ":" + historicalData.get(i - featureLength + m - 1);
     }

     f.println(historicalData.get(i) + feature);

     }
     }

     f.close();

     }

     connection.close();

     } catch (Exception e) {
     e.printStackTrace();
     System.out.println("database operation error 2.");
     }

     }
     */
    public void testWithRDP() {

        historicalData = new ArrayList<>();
        historicalDate = new ArrayList<>();

        try {

            Connection connection;

            connection = DriverManager.getConnection(DatabaseManager.URL + DatabaseManager.DATABASE_NAME, DatabaseManager.USER_NAME, DatabaseManager.PASSWORD);

            Statement statement = connection.createStatement();

            for (int j = 0; j < StockForecaster.SYMBOLS.length; j++) {

                loadData(j);

                PrintWriter f = new PrintWriter(new FileWriter("SVM/libsvm-3.20/stock/" + "SVMHistroy_" + StockForecaster.SYMBOLS[j] + "_test.txt"));

                for (int i = featureLength; i < historicalData.size(); i++) {

                    String feature = "";

                    for (int m = 1; m <= featureLength; m++) {
                        feature += " " + m + ":" + historicalData.get(i - featureLength + m - 1);
                    }

                    f.println(historicalData.get(i) + feature);

                }

                f.close();

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
