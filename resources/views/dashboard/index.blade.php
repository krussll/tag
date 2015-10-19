@extends('shared.full')

@section('content')
<div ng-controller="dashboardController" ng-init="dashboard.init()" ng-cloak>
  <div>
      @include('account.account-header-partial')
      <div class="row">
        <div class="col-md-8 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Active Trades</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content" ng-class="{loadingsection: dashboard.control.isLoading}">
                  <table class="table">
                    <thead>
                    <tr>
                      <th>Profile</th><th class="hidden-xs">Date Started</th><th class="hidden-xs">Shares Taken</th><th>Price Taken</th><th>Current Price</th><th>Change</th><th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="trade in dashboard.activeTrades">
                      <td><a href="/profile/{{trade.hashtag.id}}">{{trade.profile.name}}</a></td><td class="hidden-xs">{{trade.created_at}}</td><td class="hidden-xs">{{trade.shares_taken}}</td><td>{{trade.price_taken | currency}}</td><td>{{trade.profile.current_price | currency}}</td>
                      <td><span ng-class="{'green': (trade.profile.current_price - trade.price_taken ) >= 0, 'red': (trade.profile.current_price - trade.price_taken ) < 0}">{{trade.change | percentageDifference:trade.price_taken:trade.profile.current_price  }}</span></td>
                      <td><cdn-sell-button button-size="xs" trade-id="{{trade.id}}" event-handler="dashboard.updateTrades()" /></td>
                    </tr>
                    <tr ng-show="dashboard.activeTrades.length == 0 && !dashboard.control.isLoading">
                      <td class="no-record" colspan="3">No Active Trades</td>
                    </tr>
                    <tr ng-show="dashboard.control.isLoading">
                      <td colspan="3"><img src="/cdn/ajax-loader.gif" /></td>
                    </tr>
                  </tbody>
                  </table>
                </div>
            </div>


            <div class="x_panel" ng-show="dashboard.popularHashtag">
                <div class="x_title">
                    <h2>Current Popular Profile Price History - {{dashboard.popularHashtag.tag}}</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <price-graph hashtag-id="{{dashboard.popularHashtag.id}}" />
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="x_panel">
                <div class="x_title">
                    <h2>Popular Profiles</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content" ng-class="{loadingsection: dashboard.control.hashtagsLoading}">
                  <table class="table">
                    <thead>
                    <tr>
                      <th>Profile</th><th>Current Price</th><th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="profile in dashboard.popularHashtags">
                      <td scope="row"><a href="/profile/{{profile.id}}">{{profile.name}}</a></td><td>${{profile.current_price | number }}</td>
                      <td><cdn-buy-button button-size="xs" hashtag-id="{{profile.id}}" tag="{{profile.name}}" price="{{profile.current_price}}" event-handler="dashboard.updateTrades()" /></td>
                    </tr>
                    <tr ng-show="dashboard.control.hashtagsLoading">
                      <td class="no-record" colspan="3"><img src="/cdn/ajax-loader.gif" /></td>
                    </tr>
                  </tbody>
                  </table>
                </div>
            </div>


            <div class="x_panel">
                <div class="x_title">
                    <h2>Your Leagues</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content" ng-class="{loadingsection: dashboard.control.leagueLoading}">
                  <table class="table">
                    <thead>
                    <tr>
                      <th colspan="2">Global</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="league in dashboard.globalLeagues">
                      <td scope="row">{{league.position}}</td><td><a href="/league/{{league.id}}">{{league.name | titlecase}}</a></td>
                    </tr>
                    <tr ng-show="dashboard.globalLeagues.length == 0 && !dashboard.control.leagueLoading">
                      <td class="no-record" colspan="2">No Global Leagues</td>
                    </tr>
                    <tr ng-show="dashboard.control.leagueLoading">
                      <td class="no-record" colspan="2"><img src="/cdn/ajax-loader.gif" /></td>
                    </tr>
                  </tbody>
                  </table>
                </div>

                <div class="x_content2" ng-class="{loadingsection: dashboard.control.leagueLoading}">
                  <table class="table">
                    <thead>
                    <tr>
                      <th colspan="2">Private</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="league in dashboard.privateLeagues">
                      <td scope="row">{{league.position}}</td><td><a href="/league/{{league.id}}">{{league.name | titlecase}}</a></td>
                    </tr>
                    <tr ng-show="dashboard.privateLeagues.length == 0 && !dashboard.control.leagueLoading">
                      <td class="no-record" colspan="2">No Private Leagues</td>
                    </tr>
                    <tr ng-show="dashboard.control.leagueLoading">
                      <td class="no-record" colspan="2"><img src="/cdn/ajax-loader.gif" /></td>
                    </tr>
                  </tbody>
                  </table>
                </div>
            </div>
        </div>
      </div>
  </div>
</div>
@stop
