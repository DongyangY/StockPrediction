package stockforecaster;
/*
 Written by: Dongyang Yao, Zihong Zheng, Weiran Fang
 Assisted by: Ke Dong
 Debugged by: Xi Zhang
 */

import java.util.*;

public class STS {

    private final int N = 14;
    private final int s = 3;

    private List<Double> getSub(List<Double> pricecls) {
        int l = pricecls.size();
        return pricecls.subList(l - N, l);
    }

    private List<Double> getSub(List<Double> pricecls, int index) {
        int l = pricecls.size();
        return pricecls.subList(l - N - index, l - index);
    }

    private Double getLast(List<Double> pricecls) {
        int l = pricecls.size();
        return pricecls.get(l - 1);
    }

    private Double getLast(List<Double> pricecls, int index) {
        int l = pricecls.size();
        return pricecls.get(l - 1 - index);
    }

    public double getK(List<Double> pricecls) {
        List<Double> price = getSub(pricecls);
        double cls = getLast(pricecls);
        double low = Collections.min(price);
        double high = Collections.max(price);
        double stk = 100 * (cls - low) / (high - low);
        return stk;
    }

    private double getK(List<Double> pricecls, int index) {
        List<Double> price = getSub(pricecls, index);
        double cls = getLast(pricecls, index);
        double low = Collections.min(price);
        double high = Collections.max(price);
        double stk = 100 * (cls - low) / (high - low);
        return stk;
    }

    public double getD(List<Double> pricecls) {
        double sum = 0;
        for (int i = 0; i <= s; i++) {
            Double stk = getK(pricecls, i);
            sum = sum + stk;
        }
        return sum / (s + 1);
    }

    private List<Double> getLK(List<Double> pricecls) {
        List<Double> getK = new ArrayList();
        for (int i = 6; i >= 0; i--) {
            Double stk = getK(pricecls, i);
            getK.add(stk);
        }
        return getK;
    }

    private List<Double> getLD(List<Double> pricecls) {
        List<Double> getK = getLK(pricecls);
        List<Double> getD = new ArrayList();
        for (int i = s; i <= 2 * s; i++) {
            Double std = (getK.get(i) + getK.get(i - 1) + getK.get(i - 2) + getK.get(i - 3)) / (s + 1);
            getD.add(std);
        }
        return getD;
    }

    public String getAction(List<Double> pricecls) {
        if (getD(pricecls) < 20) {
            return "BUY";
        } else if (getD(pricecls) > 80) {
            return "SELL";
        } else {
            return "HOLD";
        }
    }

    public Double getPrediction(List<Double> pricecls) {
        List<Double> getD = getLD(pricecls);
        int l = getD.size() - 1;
        List<Double> price = getSub(pricecls);
        double low = Collections.min(price);
        double high = Collections.max(price);

        Double a3 = getD.get(l) - getD.get(l - 1);
        Double a2 = getD.get(l - 1) - getD.get(l - 2);
        Double a1 = getD.get(l - 2) - getD.get(l - 3);
        Double preD = (a1 + a2 + a3) / s + getK(pricecls);
        Double preP = (preD / 100) * (high - low) + low;
        return preP;
    }

    public List<Double> getShort(List<Double> pricecls) {
        List<Double> cls = new ArrayList<Double>();
        int l = pricecls.size();
        for (int i = 21; i > 0; i--) {
            cls.add(pricecls.get(l - i));
        }
        List<Double> clsTd = pricecls.subList(pricecls.size() - 21, pricecls.size() - 1);
        List<Double> prelist = new ArrayList<Double>();
        prelist.add(Math.round(getPrediction(clsTd) * 100.0) / 100.0);

        for (int i = 0; i < 3; i++) {
            Double p = getPrediction(cls);
            p = Math.round(p * 100.0) / 100.0;
            prelist.add(p);
            cls.add(p);
        }
        return prelist;
    }

    public Double getDiff(List<Double> pricecls) {
        Double today = pricecls.get(pricecls.size() - 1);
        Double t = getShort(pricecls).get(0);
        Double diff = Math.abs((today - t) * 100 / today);
        diff = Math.round(diff * 100.0) / 100.0;
        return diff;
    }

}
