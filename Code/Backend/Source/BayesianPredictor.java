package stockforecaster;

/*
 Written by: Dongyang Yao, Zihong Zheng, Weiran Fang
 Assisted by: Ke Dong
 Debugged by: Xi Zhang
 */
import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class BayesianPredictor {

    // Parameter setting: alpha, beta, M, N
    private final double alpha = 0.005;
    private final double beta = 11.1;
    private final int polynomialOrder = 5;
    private final int trainningDataLength = 10;

    // Bayesian computation class
    private Bayesian bayesian;

    // Stock history data
    private ArrayList<Double> historicalData;
    private ArrayList<String> historicalDate;

    // Trainning data 
    private double[] trainningInput;
    private double[] trainningOutput;

    // The next point
    private double testInput;

    public BayesianPredictor() {

    }

    public void LongTermPredictAll() {
        trainningInput = new double[trainningDataLength];
        trainningOutput = new double[trainningDataLength];
        historicalData = new ArrayList();
        historicalDate = new ArrayList();

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
                for (int i = 0; i < trainningDataLength; i++) {
                    trainningInput[i] = i + 1;
                    trainningOutput[i] = LongTermList.get(LongTermList.size() - trainningDataLength + i);
                }
                testInput = trainningDataLength + 1;
                bayesian = new Bayesian(alpha, beta, polynomialOrder);
                double Lprediction1 = bayesian.getPrediction(trainningInput, trainningOutput, testInput, -1);

                shiftOneDay(Lprediction1);
                bayesian = new Bayesian(alpha, beta, polynomialOrder);
                double Lprediction2 = bayesian.getPrediction(trainningInput, trainningOutput, testInput, -1);

                LongTermList.add(Lprediction1);
                LongTermList.add(Lprediction2);

                for (int i = 0; i < LongTermList.size(); i++) {
                    double displaynum = Math.round(LongTermList.get(i) * 100.0) / 100.0;
                    Statement stat = connection.createStatement();
                    stat.executeUpdate("INSERT INTO Lpredictionbayesian VALUES ('" + StockForecaster.SYMBOLS[j] + "', " + (i - LongTermList.size() + 3) + "," + displaynum + ")");

                }
            }

            connection.close();
        } catch (Exception e) {
            e.printStackTrace();
            System.out.println("database operation error 2.");
        }
    }

    public void ShortTermPredictAll() {

        trainningInput = new double[trainningDataLength];
        trainningOutput = new double[trainningDataLength];
        historicalData = new ArrayList();
        historicalDate = new ArrayList();

        try {

            Connection connection;

            connection = DriverManager.getConnection(DatabaseManager.URL + DatabaseManager.DATABASE_NAME, DatabaseManager.USER_NAME, DatabaseManager.PASSWORD);

            Statement statement = connection.createStatement();

            for (int j = 0; j < StockForecaster.SYMBOLS.length; j++) {

                // Load history data of each company
                loadData(j);

                double differencePast = 0;
                double predictionPast = 0;

                for (int i = 0; i < (historicalData.size() - 10); i++) {

                    // Initialize the data set
                    initializeTrainningData(i);

                    bayesian = new Bayesian(alpha, beta, polynomialOrder);
                    double prediction0 = bayesian.getPrediction(trainningInput, trainningOutput, testInput, -1);

                    //System.out.println(StockForecaster.SYMBOLS[j] + " " + historicalDate.get(i + trainningDataLength - 1));
                    ResultSet resToday = statement.executeQuery("SELECT * FROM StockHistorical WHERE Symbol = '" + StockForecaster.SYMBOLS[j] + "' AND Date = '" + historicalDate.get(i + trainningDataLength) + "'");

                    double priceToday = 0.0;

                    while (resToday.next()) {
                        priceToday = resToday.getDouble("ClosePrice");
                    }

                    ResultSet res = statement.executeQuery("SELECT * FROM StockHistorical WHERE Symbol = '" + StockForecaster.SYMBOLS[j] + "' AND Date = '" + historicalDate.get(i + trainningDataLength - 1) + "'");

                    while (res.next()) {

                        double difference = prediction0 - res.getDouble("ClosePrice");
                        String action;

                        double RelativeDifference = (difference / res.getDouble("ClosePrice")) * 100;

                        initializeTrainningData(i + 1);
                        bayesian = new Bayesian(alpha, beta, polynomialOrder);
                        double prediction1 = bayesian.getPrediction(trainningInput, trainningOutput, testInput, -1);

                        shiftOneDay(prediction1);
                        bayesian = new Bayesian(alpha, beta, polynomialOrder);
                        double prediction2 = bayesian.getPrediction(trainningInput, trainningOutput, testInput, -1);

                        prediction0 = Math.round(prediction0 * 100.0) / 100.0;
                        prediction1 = Math.round(prediction1 * 100.0) / 100.0;
                        prediction2 = Math.round(prediction2 * 100.0) / 100.0;

                        // if (difference < 0 && res.getDouble("CloseDifference") > 0) {
                        //     action = "Sell";
                        // } else if (difference > 0 && res.getDouble("CloseDifference") < 0) {
                        //     action = "Buy";
                        // } else {
                        //     action = "Hold";
                        // }
                        if (prediction1 > priceToday) {
                            action = "BUY";
                        } else if (prediction1 < priceToday) {
                            action = "SELL";
                        } else {
                            action = "HOLD";
                        }

                        //System.out.println(StockForecaster.SYMBOLS[j] + " " + historicalDate.get(i + trainningDataLength) + " " + prediction + " " + action);
                        RelativeDifference = Math.round(Math.abs(RelativeDifference) * 100.0) / 100.0;

                        Statement stat = connection.createStatement();
                        stat.executeUpdate("INSERT INTO Spredictionbayesian VALUES ('" + StockForecaster.SYMBOLS[j] + "', '" + historicalDate.get(i + trainningDataLength) + "', " + prediction0 + ", " + prediction1 + " , " + prediction2 + ", " + RelativeDifference + ",'" + action + "')");

                        //System.out.println(StockForecaster.SYMBOLS[j] + " " + historicalDate.get(i + trainningDataLength) + " " + prediction + " " + RelativeDifference + " " + action);
                        //System.out.println();
                    }

                }

            }

            connection.close();

        } catch (Exception e) {
            e.printStackTrace();
            System.out.println("database operation error 2.");
        }

    }

    // Initialize the data set
    private void initializeTrainningData(int startPoint) {

        for (int i = 0; i < trainningDataLength; i++) {
            trainningInput[i] = i + 1;
            trainningOutput[i] = historicalData.get(i + startPoint);
        }

        testInput = trainningDataLength + 1;
    }

    private void shiftOneDay(double newPoint) {
        for (int i = 0; i < trainningOutput.length - 1; i++) {
            trainningOutput[i] = trainningOutput[i + 1];
        }
        trainningOutput[trainningOutput.length - 1] = newPoint;
    }

    // Load history Data
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
