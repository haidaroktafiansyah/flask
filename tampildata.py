import snscrape.modules.twitter as sntwitter
import pandas as pd
import predict as predictFile
import numpy as np
import crawl as cr
from flask import Flask, jsonify, request

df = pd.read_csv("./train_data.csv")
df2 = pd.read_csv("./test_data.csv")

app = Flask(__name__)
@app.route('/trainingDatas')
def index():
    return df.to_json(orient='records')

@app.route('/prediction')
def index2():
    data = predictFile.update()
    return data.to_json(orient='records')

@app.route('/crawlDatas' , methods=["POST"])
def index3():
    query = request.json
    data = cr.crawls(query['inputQuery'])
    return data.to_json(orient='records')

@app.route('/testDatas')
def index4():
    return df2.to_json(orient='records')

app.run()