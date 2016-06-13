package stockforecaster;

/*
 Written by: Dongyang Yao, Zihong Zheng, Weiran Fang
 Assisted by: Ke Dong
 Debugged by: Xi Zhang
 */
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;

public class AI {

    private List<List<Double>> Data;
    private List<List<String>> Date;
    private List<List<String>> BAYAction;
    private List<List<String>> STSAction;
    private List<List<String>> SVMAction;
    private List<List<String>> ANNAction;
    private double BAYBalance;
    private int[] BAYNumStock;
    private double STSBalance;
    private int[] STSNumStock;
    private double SVMBalance;
    private int[] SVMNumStock;
    private double ANNBalance;
    private int[] ANNNumStock;

    public AI() {

        Data = new ArrayList();
        for (int i = 0; i < 10; ++i) {
            Data.add(new ArrayList());
        }
        Date = new ArrayList();
        for (int i = 0; i < 10; ++i) {
            Date.add(new ArrayList());
        }
        BAYAction = new ArrayList();
        for (int i = 0; i < 10; ++i) {
            BAYAction.add(new ArrayList());
        }
        STSAction = new ArrayList();
        for (int i = 0; i < 10; ++i) {
            STSAction.add(new ArrayList());
        }
        SVMAction = new ArrayList();
        for (int i = 0; i < 10; ++i) {
            SVMAction.add(new ArrayList());
        }
        ANNAction = new ArrayList();
        for (int i = 0; i < 10; ++i) {
            ANNAction.add(new ArrayList());
        }

        BAYBalance = 1000000;
        STSBalance = 1000000;
        SVMBalance = 1000000;
        ANNBalance = 1000000;

        BAYNumStock = new int[10];
        STSNumStock = new int[10];
        SVMNumStock = new int[10];
        ANNNumStock = new int[10];

    }

    public void runAI() {

        double balanceTemp;

        for (int i = 0; i < StockForecaster.SYMBOLS.length; ++i) {

            loadData(i);

        }

        for (int j = SVMAction.get(0).size() - 1; j >= 0; j--) {

            String date = Date.get(0).get(j);

            Double Total = SVMBalance;

            for (int i = 0; i < StockForecaster.SYMBOLS.length; ++i) {
                Total += SVMNumStock[i] * Data.get(i).get(j);
            }

            try {

                Connection connection;

                connection = DriverManager.getConnection(DatabaseManager.URL + DatabaseManager.DATABASE_NAME, DatabaseManager.USER_NAME, DatabaseManager.PASSWORD);

                Statement statement = connection.createStatement();

                statement.executeUpdate("INSERT INTO AISVM VALUES ('" + date + "', " + Math.round(Total * 100.0) / 100.0 + ")");

                connection.close();

            } catch (Exception e) {
                System.out.println("database operation error 1.");
            }

            balanceTemp = SVMBalance;
            for (int i = 0; i < StockForecaster.SYMBOLS.length; ++i) {
//                System.out.println(balanceTemp);
                if (SVMAction.get(i).get(j).equals("BUY")) {

                    Double price = Data.get(i).get(j);

                    int numStock = (int) (balanceTemp * 0.2 * 0.1 / price);
                    SVMBalance -= numStock * price;
                    SVMNumStock[i] += numStock;

                }

                if (SVMAction.get(i).get(j).equals("SELL")) {

                    Double price = Data.get(i).get(j);

                    SVMBalance += (SVMNumStock[i] / 50) * price;
                    SVMNumStock[i] -= SVMNumStock[i] / 50;

                }
            }
        }

        for (int j = ANNAction.get(0).size() - 1; j >= 0; j--) {

            String date = Date.get(0).get(j);

            Double Total = ANNBalance;

            for (int i = 0; i < StockForecaster.SYMBOLS.length; ++i) {
                Total += ANNNumStock[i] * Data.get(i).get(j);
            }

            try {

                Connection connection;

                connection = DriverManager.getConnection(DatabaseManager.URL + DatabaseManager.DATABASE_NAME, DatabaseManager.USER_NAME, DatabaseManager.PASSWORD);

                Statement statement = connection.createStatement();

                statement.executeUpdate("INSERT INTO AIANN VALUES ('" + date + "', " + Math.round(Total * 100.0) / 100.0 + ")");

                connection.close();

            } catch (Exception e) {
                System.out.println("database operation error 1.");
            }

            balanceTemp = ANNBalance;
            for (int i = 0; i < StockForecaster.SYMBOLS.length; ++i) {
                if (ANNAction.get(i).get(j).equals("BUY")) {

                    Double price = Data.get(i).get(j);

                    int numStock = (int) (balanceTemp * 0.2 * 0.1 / price);

                    ANNBalance -= numStock * price;
                    ANNNumStock[i] += numStock;

                }

                if (ANNAction.get(i).get(j).equals("SELL")) {

                    Double price = Data.get(i).get(j);

                    ANNBalance += (ANNNumStock[i] / 50) * price;
                    ANNNumStock[i] -= ANNNumStock[i] / 50;

                }
            }
        }

        // BAY
        for (int j = BAYAction.get(0).size() - 1; j >= 0; j--) {

            String date = Date.get(0).get(j);

            Double Total = BAYBalance;

            for (int i = 0; i < StockForecaster.SYMBOLS.length; ++i) {
                Total += BAYNumStock[i] * Data.get(i).get(j);
            }

            try {

                Connection connection;

                connection = DriverManager.getConnection(DatabaseManager.URL + DatabaseManager.DATABASE_NAME, DatabaseManager.USER_NAME, DatabaseManager.PASSWORD);

                Statement statement = connection.createStatement();

                statement.executeUpdate("INSERT INTO AIBAY VALUES ('" + date + "', " + Math.round(Total * 100.0) / 100.0 + ")");

                connection.close();

            } catch (Exception e) {
                System.out.println("database operation error 1.");
            }

            balanceTemp = BAYBalance;
            for (int i = 0; i < StockForecaster.SYMBOLS.length; ++i) {

                if (BAYAction.get(i).get(j).equals("BUY")) {

                    Double price = Data.get(i).get(j);

                    int numStock = (int) (balanceTemp * 0.2 * 0.1 / price);

                    BAYBalance -= numStock * price;
                    BAYNumStock[i] += numStock;

                }

                if (BAYAction.get(i).get(j).equals("SELL")) {

                    Double price = Data.get(i).get(j);

                    BAYBalance += (BAYNumStock[i] / 50) * price;
                    BAYNumStock[i] -= BAYNumStock[i] / 50;

                }
            }
        }

        // STS
        for (int j = STSAction.get(0).size() - 1; j >= 0; j--) {

            String date = Date.get(0).get(j);

            Double Total = STSBalance;

            for (int i = 0; i < StockForecaster.SYMBOLS.length; ++i) {
                Total += STSNumStock[i] * Data.get(i).get(j);
            }

            try {

                Connection connection;

                connection = DriverManager.getConnection(DatabaseManager.URL + DatabaseManager.DATABASE_NAME, DatabaseManager.USER_NAME, DatabaseManager.PASSWORD);

                Statement statement = connection.createStatement();

                statement.executeUpdate("INSERT INTO AISTS VALUES ('" + date + "', " + Math.round(Total * 100.0) / 100.0 + ")");

                connection.close();

            } catch (Exception e) {
                System.out.println("database operation error 1.");
            }

            balanceTemp = STSBalance;
            for (int i = 0; i < StockForecaster.SYMBOLS.length; ++i) {

                if (STSAction.get(i).get(j).equals("BUY")) {

                    Double price = Data.get(i).get(j);

                    int numStock = (int) (balanceTemp * 0.2 * 0.1 / price);

                    STSBalance -= numStock * price;
                    STSNumStock[i] += numStock;

                }

                if (STSAction.get(i).get(j).equals("SELL")) {

                    Double price = Data.get(i).get(j);

                    STSBalance += (STSNumStock[i] / 50) * price;
                    STSNumStock[i] -= STSNumStock[i] / 50;

                }
            }
        }

    }

    private void loadData(int CompanyIndex) {

        try {

            Connection connection;

            connection = DriverManager.getConnection(DatabaseManager.URL + DatabaseManager.DATABASE_NAME, DatabaseManager.USER_NAME, DatabaseManager.PASSWORD);

            Statement statement = connection.createStatement();

            // load price and date
            ResultSet res = statement.executeQuery("SELECT * FROM StockHistorical WHERE Symbol = '" + StockForecaster.SYMBOLS[CompanyIndex] + "' order by Date desc limit 200");

            while (res.next()) {
                Data.get(CompanyIndex).add(res.getDouble("ClosePrice"));
                Date.get(CompanyIndex).add(res.getString("Date"));
            }

            // load action
            res = statement.executeQuery("SELECT * FROM SPredictionBayesian WHERE Symbol = '" + StockForecaster.SYMBOLS[CompanyIndex] + "' order by Date desc limit 200");

            while (res.next()) {
                BAYAction.get(CompanyIndex).add(res.getString("Action"));
            }

            res = statement.executeQuery("SELECT * FROM SPredictionSTS WHERE Symbol = '" + StockForecaster.SYMBOLS[CompanyIndex] + "' order by Date desc limit 200");

            while (res.next()) {
                STSAction.get(CompanyIndex).add(res.getString("Action"));
            }

            res = statement.executeQuery("SELECT * FROM PredictionSVM WHERE Symbol = '" + StockForecaster.SYMBOLS[CompanyIndex] + "' AND Date != 'predict day 2' order by Date desc limit 200");

            while (res.next()) {
                SVMAction.get(CompanyIndex).add(res.getString("Action"));
            }

            res = statement.executeQuery("SELECT * FROM PredictionANN WHERE Symbol = '" + StockForecaster.SYMBOLS[CompanyIndex] + "' AND Date != 'predict day 2' order by Date desc limit 200");

            while (res.next()) {
                ANNAction.get(CompanyIndex).add(res.getString("Action"));
            }

            connection.close();

        } catch (Exception e) {
            System.out.println("database operation error 1.");
        }

    }

}
